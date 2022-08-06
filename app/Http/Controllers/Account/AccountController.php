<?php

namespace App\Http\Controllers\Account;


use App\Http\Controllers\Controller;
use App\Models\Accounts\Account;

use App\Models\Accounts\Bank;
use App\Models\Accounts\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use DB;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.account.index');
    }

    /**
     * Display all data list using ajax.
     * Server side
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccountList(Request $request){
        $columns = array(
            0 => 'id',
            1 => 'account_no',
            2 => 'bank_id',
            3 => 'branch_name',
            4 => 'balance',
            5 => 'actions'
        );

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        //Collect data according to role
        if ($user_role->name == 'Super Admin') {

            $totalData = $totalFiltered = Account::count();

        } elseif ($user_role->name == 'Admin') {

            //admin_id column has main admin id
            $totalData = $totalFiltered = Account::where('admin_id', $Auth->id)
                ->count();

        } else {

            //created_by column has main current user id
            $totalData = $totalFiltered = Account::where('created_by', $Auth->id)
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
                $accounts = Account::with('bank')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

            } elseif ($user_role->name == 'Admin') {
                $accounts = Account::with('bank')
                    ->where('admin_id', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();
            } else {
                $accounts = Account::with('bank')
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
                $accounts = Account::with('bank')
                    ->where('account_no', 'LIKE', "%{$search}%")
                    ->orWhere('branch_name', 'LIKE', "%{$search}%")
                    ->orWhere('balance', 'LIKE', "%{$search}%")
                    ->orWhereHas('bank', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                //Collect total count value
                $totalFiltered = Account::with('bank')
                    ->where('account_no', 'LIKE', "%{$search}%")
                    ->orWhere('branch_name', 'LIKE', "%{$search}%")
                    ->orWhere('balance', 'LIKE', "%{$search}%")
                    ->orWhereHas('bank', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->count();

            } elseif ($user_role->name == 'Admin') {

                $accounts = Account::with('bank')
                    ->where('admin_id', $Auth->id)
                    ->where(function($query) use ($search) {
                        $query->where('account_no', 'LIKE', '%'.$search.'%')
                            ->orWhere('balance', 'LIKE', '%'.$search.'%')
                            ->orWhere('branch_name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('bank', function ($query) use ($search) {
                        $query->where('admin_id', Auth::id()); //admin_id is auth
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Account::with('bank')
                    ->where('admin_id', $Auth->id)
                    ->where(function($query) use ($search) {
                        $query->where('account_no', 'LIKE', '%'.$search.'%')
                            ->orWhere('balance', 'LIKE', '%'.$search.'%')
                            ->orWhere('branch_name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('bank', function ($query) use ($search, $Auth) {
                        $query->where('admin_id', Auth::id()); //admin_id is auth
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->count();

            } else {
                $accounts = Account::with('bank')
                    ->where('created_by', $Auth->id)
                    ->where(function($query) use ($search, $Auth) {
                        $query->where('account_no', 'LIKE', '%'.$search.'%')
                            ->orWhere('balance', 'LIKE', '%'.$search.'%')
                            ->orWhere('branch_name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('bank', function ($query) use ($search, $Auth) {
                        $query->where('created_by', Auth::id());
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Account::with('bank')
                    ->where('admin_id', $Auth->id)
                    ->where(function($query) use ($search, $Auth) {
                        $query->where('account_no', 'LIKE', '%'.$search.'%')
                            ->orWhere('balance', 'LIKE', '%'.$search.'%')
                            ->orWhere('branch_name', 'LIKE', '%'.$search.'%');
                    })
                    ->count();
            }

        }

        //Display data
        $data = array();
        if (!empty($accounts)) {
            foreach ($accounts as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['account_no'] = $value->account_no;
                $nestedData['bank_id'] = $value->bank->first()->name;
                $nestedData['branch_name'] = $value->branch_name;
                $nestedData['balance'] = $value->balance;
                $nestedData['actions'] = '<div class="">
                    <a href=" ' . route('accounts.show', $value->id) . ' " title="Show">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-info">
                            <i class="fa fa-eye btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a href=" ' . route('accounts.transactions.reports', $value->id) . ' " title="Report">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-inverse">
                            <i class="fa fa-file-alt btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a href=" ' . route('accounts.edit', $value->id) . ' " title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-success">
                            <i class="fa fa-edit btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <button class="mr-2 btn-icon btn-icon-only btn btn-danger btn-delete" data-remote=" ' . route('accounts.destroy', $value->id) . ' " title="Delete">
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
        $banks = $this->getBankAsRole();
        return view('account.account.create',compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'account_no.required' => 'Account number is Required.',
            'bank_id.required' => 'Bank Name is Required.',
            'branch_name.required' => 'Branch Name is Required.',
            'initial_balance.required' => 'Initial balance is Required.',
        );
        $this->validate($request, array(
            'account_no' => 'required',
            'bank_id' => 'required',
            'branch_name' => 'required',
            'initial_balance' => 'required|numeric',
        ), $messages);

        try {

            DB::transaction(function() use ($request) {

                $auth = Auth::user();
                $user_role = $auth->roles->first();

                //Set parent admin id
                if ($user_role->name == 'Super Admin') {

                    $parent_admin_id = 1;
                } elseif ($user_role->name == 'Admin') {

                    //set admin id as own id if auth's role is admin
                    $parent_admin_id = $auth->id;
                } else {

                    //set admin id as its parent id if auth's role is not and admin or super admin
                    $parent_admin_id = $auth->parent_admin_id;
                }

                $data = new Account();

                $data->account_no = $request->account_no;
                $data->bank_id = $request->bank_id;
                $data->initial_balance = $request->initial_balance ?? 0;
                $data->balance = $request->initial_balance; //current balance is initial balance
                $data->branch_name = $request->branch_name;
                $data->remarks = $request->remarks;
                $data->created_by = $auth->id;
                $data->admin_id = $parent_admin_id;

                $data->save();

                //Transaction part
                $transaction = new Transaction();

                $transaction->created_by = $auth->id;
                $transaction->admin_id = $parent_admin_id;
                $transaction->date = Carbon::today()->toDateString();
                $transaction->account_id = $data->id;
                //$transaction->account_id = $request->account_if;
                $transaction->amount = $request->initial_balance ?? 0;
                $transaction->post_balance = $request->initial_balance ?? 0;
                $transaction->purpose = 0;

                $transaction->save();
            });


            return redirect()
                ->route('accounts.index')
                ->with('success', 'Created Successfully');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return view('account.account.show',compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        try {
            $banks = $this->getBankAsRole();
            return view('account.account.edit',compact('account','banks'));
        }
        catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $messages = array(
            'account_no.required' => 'Account number is Required.',
            'bank_id.required' => 'Bank Name is Required.',
            'branch_name.required' => 'Branch Name is Required.',
            'initial_balance.required' => 'Initial balance is Required.',
        );
        $this->validate($request, array(
            'account_no' => 'required',
            'bank_id' => 'required',
            'branch_name' => 'required',
            'initial_balance' => 'required|numeric',
        ), $messages);

        try {

            $account->account_no = $request->account_no;
            $account->bank_id = $request->bank_id;
            $account->initial_balance = $request->initial_balance;
            $account->balance = $request->initial_balance; //current balance is initial balance
            $account->branch_name = $request->branch_name;
            $account->remarks = $request->remarks;
            $account->updated_by = Auth::id();

            $account->update();

            return redirect()
                ->route('accounts.index')
                ->with('success', 'Updated Successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();
    }


    public function accountsTransactionsReports($id){

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        $account = Account::findOrFail($id);
        $balance = $account->initial_balance;


        //Collect data according to role
        if ($user_role->name == 'Super Admin') {

            $transactions = Transaction::where('account_id',$account->id)
//                            ->latest()
                            ->get();


            //dd($amount->first());

        } elseif ($user_role->name == 'Admin') {

            //admin_id column has main admin id
            $transactions = Transaction::where('account_id',$account->id)
                            ->where('admin_id', $Auth->id)
//                            ->latest()
                            ->get();

        } else {

            //created_by column has main current user id
            $transactions = Transaction::where('account_id',$account->id)
                            ->where('created_by', $Auth->id)
//                            ->latest()
                            ->get();

        }

        return view('account.account.transaction-report',
            compact('account','transactions','balance'));
    }

    public function getAccountsTransactionsReports(Request $request){
        $columns = array(
            0 => 'id',
            1 => 'date',
            2 => 'purpose',
            3 => 'cash_in',
            4 => 'cash_out',
            5 => 'balance'
        );

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        $account = Account::findOrFail($request->account_id);


        //Collect data according to role
        if ($user_role->name == 'Super Admin') {

            $totalData = $totalFiltered = Transaction::where('account_id',$request->account_id)
                                                        ->count();

        } elseif ($user_role->name == 'Admin') {

            //admin_id column has main admin id
            $totalData = $totalFiltered = Transaction::where('account_id',$request->account_id)
                ->where('admin_id', $Auth->id)
                ->count();

        } else {

            //created_by column has main current user id
            $totalData = $totalFiltered = Transaction::where('account_id',$request->account_id)
                ->where('created_by', $Auth->id)
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
                $transactions = Transaction::where('account_id',$request->account_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    //->orderBy('id', 'DESC')
                    ->latest()
                    ->get();

            } elseif ($user_role->name == 'Admin') {
                $transactions = Transaction::where('account_id',$request->account_id)
                    ->where('admin_id', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();
            } else {
                $transactions = Transaction::where('account_id',$request->account_id)
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
                $transactions = Transaction::where('account_id',$request->account_id)
                    ->where('purpose', 'LIKE', "%{$search}%")
                    ->where('date', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                //Collect total count value
                $totalFiltered = Transaction::where('account_id',$request->account_id)
                    ->where('purpose', 'LIKE', "%{$search}%")
                    ->count();

            } elseif ($user_role->name == 'Admin') {

                $transactions = Account::where('account_id',$request->account_id)
                    ->where('admin_id', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Account::where('account_id',$request->account_id)
                    ->where('admin_id', $Auth->id)
                    ->count();

            } else {
                $transactions = Account::where('account_id',$request->account_id)
                    ->where('created_by', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Account::where('account_id',$request->account_id)
                    ->where('admin_id', $Auth->id)
                    ->count();
            }
        }

        //Display data
        $data = array();
        if (!empty($transactions)) {
            $balance = $account->initial_balance;
            foreach ($transactions as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date->format('d M, Y');
                //Collect purpose
                $cash_in = 0;
                $cash_out = 0;
                if($value->purpose == 0){
                    $purpose = "Initial Balance";
                    $cash_in = $value->amount;
                    $cash_out = 0;
                    $balance = $value->amount;
                }
                elseif($value->purpose == 1){
                    $purpose = "Withdraw";
                    $cash_in = 0;
                    $cash_out = $value->amount;
                    $balance = $balance - $value->amount;
                }

                elseif($value->purpose == 2){
                    $purpose = "Deposit";
                    $cash_in = $value->amount;
                    $cash_out = 0;
                    $balance += $value->amount;
                }

                elseif($value->purpose == 3){
                    $purpose = "Received Payment";
                    $cash_in = $value->amount;
                    $cash_out = 0;
                    $balance = $balance + $value->amount;
                }

                elseif($value->purpose == 4){
                    $purpose = "Given Payment";
                    $cash_in = 0;
                    $cash_out = $value->amount;
                    $balance = $balance - $value->amount;
                }
                else
                    $purpose = "Others";

                $nestedData['purpose'] = $purpose;

                $nestedData['cash_in'] = $cash_in;
                $nestedData['cash_out'] = $cash_out;

                $nestedData['balance'] = $balance;

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


    //Get Bank Id and Name As User Role.
    public function getBankAsRole(){

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        //Collect bank name and id according to role
        if ($user_role->name == 'Super Admin') {

            //Super admin can get all bank name
            $banks = Bank::get(['name', 'id']);

        } elseif ($user_role->name == 'Admin') {

            //collect bank account id auth is admin.admin_id column has all admin id
            $banks = Bank::where('admin_id', $Auth->id)
                ->get(['name', 'id']);

        } else {

            //collect bank account id auth is not an admin or super admin.created_by column has all current auth id
            $banks = Bank::where('admin_id', $Auth->parent_admin_id)
                ->get(['name', 'id']);
        }

        return $banks;
    }
}
