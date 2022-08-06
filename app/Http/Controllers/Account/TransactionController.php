<?php

namespace App\Http\Controllers\Account;

use App\Models\Accounts\Account;
use App\Models\Accounts\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $t = Transaction::with('accounts')->first();
//        dd($t->accounts->first()->account_no);

        return view('account.transaction.index');
    }

    /**
     * Display all data list using ajax.
     * Server side
     *
     * @return \Illuminate\Http\Response
     */
    public function getTransactionList(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'date',
            2 => 'account_id',
            3 => 'purpose',
            4 => 'amount',
            5 => 'actions'
        );

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        //Collect data according to role
        if ($user_role->name == 'Super Admin') {

            $totalData = $totalFiltered = Transaction::count();

        } elseif ($user_role->name == 'Admin') {

            //admin_id column has main admin id
            $totalData = $totalFiltered = Transaction::where('admin_id', $Auth->id)
                ->count();

        } else {

            //created_by column has main current user id
            $totalData = $totalFiltered = Transaction::where('created_by', $Auth->id)
                ->count();
        }

        if ($request->input('length') == -1) {
            $limit = $totalData;
        } else {
            $limit = $request->input('length');
        }

        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        if (empty($request->input('search.value'))) {

            //Collect data according to role
            if ($user_role->name == 'Super Admin') {
                $Transactions = Transaction::with('accounts')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

            } elseif ($user_role->name == 'Admin') {
                $Transactions = Transaction::with('accounts')
                    ->where('admin_id', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();
            } else {
                $Transactions = Transaction::with('accounts')
                    ->where('created_by', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();
            }

        } else {

            //Collect search data according to role
            $search = $request->input('search.value');

            if ($user_role->name == 'Super Admin') {
                $Transactions = Transaction::where('amount', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                //Collect total count value
                $totalFiltered = Transaction::where('amount', 'LIKE', "%{$search}%")
                    ->count();

            } elseif ($user_role->name == 'Admin') {

                $Transactions = Transaction::where('admin_id', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Transaction::where('admin_id', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->count();

            } else {
                $Transactions = Transaction::where('created_by', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Transaction::where('created_by', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->count();
            }

        }

        //Display data
        $data = array();
        if (!empty($Transactions)) {
            foreach ($Transactions as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date->format('d M, Y');
                $nestedData['account_id'] = isset($value->accounts[0]) ? $value->accounts->first()->account_no : '-';

                //Collect purpose
                if ($value->purpose == 0)
                    $purpose = "Initial Balance";
                elseif ($value->purpose == 1)
                    $purpose = "Withdraw";
                elseif ($value->purpose == 2)
                    $purpose = "Deposit";
                elseif ($value->purpose == 3)
                    $purpose = "Received Payment";
                elseif ($value->purpose == 4)
                    $purpose = "Given Payment";
                else
                    $purpose = "Others";

                $nestedData['purpose'] = $purpose;
                $nestedData['amount'] = $value->amount;

                $nestedData['actions'] = '<div class="">
                    <a href=" ' . route('transactions.show', $value->id) . ' " title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-inverse">
                            <i class="fa fa-file-alt btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a href=" ' . route('transactions.edit', $value->id) . ' " title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-success">
                            <i class="fa fa-edit btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <button class="mr-2 btn-icon btn-icon-only btn btn-danger btn-delete" data-remote=" ' . route('transactions.destroy', $value->id) . ' " title="Delete">
                        <i class="fa fa-trash btn-icon-wrapper"></i>
                    </button>
                </div>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return response()->json($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $accounts = $this->getAccountAsRole();
        return view('account.transaction.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'date.required' => 'Date is Required.',
            'account_id.required' => 'Account is Required.',
            'amount.required' => 'Amount is Required.',
            'purpose.required' => 'Purpose is Required.',
            'type.required' => 'Type is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'account_id' => ['required', Rule::notIn(['', '0'])],
            'amount' => 'required|numeric',
            'purpose' => ['required', Rule::notIn(['', '0'])],
            'type' => Rule::requiredIf($request->purpose == 3 || $request->purpose == 4, Rule::notIn(['', '0'])),
        ), $messages);


        try {

            DB::transaction(function () use ($request) {

                $auth = Auth::user();
                $userRole = $auth->roles->first();

                //Set parent admin id
                if ($userRole->name == 'Super Admin') {
                    $parentAdminId = 1;
                } elseif ($userRole->name == 'Admin') {

                    //set admin id as own id if auth's role is admin
                    $parentAdminId = $auth->id;
                } else {

                    //set admin id as its parent id if auth's role is not and admin or super admin
                    $parentAdminId = $auth->parent_admin_id;
                }

                $accountNo = Transaction::where('account_id', $request->account_id)->latest()->first();

                if ($accountNo) {
                    if ($request->purpose == 1) {
                        $accountPostBalance = $accountNo->post_balance - $request->amount;
                    } elseif ($request->purpose == 2) {
                        $accountPostBalance = $accountNo->post_balance + $request->amount;
                    } elseif ($request->purpose == 3) {
                        $accountPostBalance = $accountNo->post_balance + $request->amount;
                    } else {
                        $accountPostBalance = $accountNo->post_balance - $request->amount;
                    }
                }

                $data = new Transaction();

                $data->created_by = $auth->id;
                $data->admin_id = $parentAdminId;
                $data->date = $request->date;
                $data->account_id = $request->account_id;
                $data->amount = $request->amount;
                $data->post_balance = $accountPostBalance;
                $data->purpose = $request->purpose;
                $data->type = $request->type;
                $data->balance_transfer_info = $request->balance_transfer_info;
                $data->cheque_number = $request->cheque_number;
                $data->remarks = $request->remarks;

                $data->save();

                //Account balance update if
                $account = Account::findOrFail($request->account_id);

                if ($account) {
                    if ($data->purpose == 1) {
                        $account->balance -= $request->amount; //Withdraw
                    } elseif ($data->purpose == 2) {
                        $account->balance += $request->amount; //Deposit
                    } elseif ($data->purpose == 3) {
                        $account->balance += $request->amount; //Received Payment
                    } else {
                        $account->balance -= $request->amount; //Given Payment
                    }
                }

                $account->update();

            });


            return redirect()
                ->route('transactions.index')
                ->with('success', 'Created Successfully');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounts\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('account.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounts\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $accounts = $this->getAccountAsRole();
        return view('account.transaction.edit', compact('accounts', 'transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Accounts\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $messages = array(
            'date.required' => 'Date is Required.',
            'account_id.required' => 'Account is Required.',
            'amount.required' => 'Amount is Required.',
            'purpose.required' => 'Purpose is Required.',
            'type.required' => 'Type is Required.',
        );
        $this->validate($request, array(
            'date' => 'required',
            'account_id' => ['required', Rule::notIn(['', '0'])],
            'amount' => 'required|numeric',
            'purpose' => ['required', Rule::notIn(['', '0'])],
            'type' => Rule::requiredIf($request->purpose == 3 || $request->purpose == 4, Rule::notIn(['', '0'])),
        ), $messages);

        try {

//            $previousTransactionAmount = $transaction->amount;
//
//            if ($transaction->amount > $request->amount) {
//
//                if($request->purpose == 1 || $request->purpose == 4){
//
//                    $diff = $transaction->amount - $request->amount;
//                    $postBalance = $transaction->post_balance + $diff;
//                }
//                else{
//
//                    $diff = $transaction->amount - $request->amount;
//                    $postBalance = $transaction->post_balance - $diff;
//                }
//
//            } else {
//
//                if($request->purpose == 1 || $request->purpose == 4){
//                    $diff = $request->amount - $transaction->amount;
//                    $postBalance = $transaction->post_balance - $diff;
//                }
//                else{
//                    $diff = $request->amount - $transaction->amount;
//                    $postBalance = $transaction->post_balance + $diff;
//                }
//
//
//            }

            $transaction->date = $request->date;
            $transaction->account_id = $request->account_id;
            $transaction->amount = $request->amount;
            $transaction->post_balance = $request->amount;
            $transaction->purpose = $request->purpose;
            $transaction->type = $request->type;
            $transaction->balance_transfer_info = $request->balance_transfer_info;
            $transaction->cheque_number = $request->cheque_number;
            $transaction->remarks = $request->remarks;
            $transaction->updated_by = Auth::id();

            $transaction->save();


//            $accounts = Transaction::where('account_id', $request->account_id)
//                ->where('id', '>', $transaction->id)
//                ->get();



//            if(count($accounts)){
//
//
//                if ($previousTransactionAmount > $request->amount) {
//
//
//                    if($request->purpose == 1 || $request->purpose == 4){
//
//                        $diff = $previousTransactionAmount - $request->amount;
//                        $postBalance = $transaction->post_balance + $diff;
//                    }
//                    else{
//                        $diff = $previousTransactionAmount - $request->amount;
//                        $postBalance = $transaction->post_balance - $diff;
//                    }
//
//                } else {
//
//                    if($request->purpose == 1 || $request->purpose == 4){
//                        $diff = $request->amount - $previousTransactionAmount;
//                        $postBalance = $transaction->post_balance - $diff;
//                    }
//                    else{
//                        $diff = $request->amount - $previousTransactionAmount;
//                        $postBalance = $transaction->post_balance + $diff;
//                    }
//
//
//                }
//
//                foreach ($accounts as $account){
//                    $account->post_balance = $postBalance;
//                }
//            }



            return redirect()
                ->route('transactions.index')
                ->with('success', 'Updated Successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounts\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
    }

    public function getAccountAsRole()
    {
        $Auth = Auth::user();
        $userRole = $Auth->roles->first();

        //Collect Transaction name and id according to role
        if ($userRole->name == 'Super Admin') {

            //Super admin can get all Transaction name
            $accounts = Account::get();

        } elseif ($userRole->name == 'Admin') {

            //collect Transaction account id auth is admin.admin_id column has all admin id
            $accounts = Account::where('admin_id', $Auth->id)
                ->get();

        } else {

            //collect Transaction account id auth is not an admin or super admin.created_by column has all current auth id
            $accounts = Account::where('admin_id', $Auth->parent_admin_id)
                ->get();
        }

        return $accounts;
    }
}
