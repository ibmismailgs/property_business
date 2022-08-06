<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use App\Models\Accounts\Bank;
use Illuminate\Http\Request;
use Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.bank.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.bank.create');
    }


    /**
     * Display all data list using ajax.
     * Server side
     *
     * @return \Illuminate\Http\Response
     */

    public function getBankList(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'created_by',
            3 => 'actions'
        );

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        //Collect data according to role
        if ($user_role->name == 'Super Admin') {

            $totalData = $totalFiltered = Bank::count();

        } elseif ($user_role->name == 'Admin') {

            //admin_id column has main admin id
            $totalData = $totalFiltered = Bank::where('admin_id', $Auth->id)
                ->count();

        } else {

            //created_by column has main current user id
            $totalData = $totalFiltered = Bank::where('created_by', $Auth->id)
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
                $banks = Bank::with('createdBy')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

            } elseif ($user_role->name == 'Admin') {
                $banks = Bank::with('createdBy')
                    ->where('admin_id', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();
            } else {
                $banks = Bank::with('createdBy')
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
                $banks = Bank::with('createdBy')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                //Collect total count value
                $totalFiltered = Bank::with('createdBy')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->count();

            } elseif ($user_role->name == 'Admin') {

                $banks = Bank::with('createdBy')
                    ->where('admin_id', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search, $Auth) {
                        $query->where('id', $Auth->id);
                        $query->orWhere('parent_admin_id', $Auth->id); //all user under admin
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Bank::with('createdBy')
                    ->where('admin_id', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search, $Auth) {
                        $query->where('id', $Auth->id);
                        $query->orWhere('parent_admin_id', $Auth->id);
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->count();

            } else {
                $banks = Bank::with('createdBy')
                    ->where('created_by', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search, $Auth) {
                        $query->where('id', $Auth->id);
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = Bank::with('createdBy')
                    ->where('created_by', $Auth->id)
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search, $Auth) {
                        $query->where('id', $Auth->id);
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->count();
            }

        }

        //Display data
        $data = array();
        if (!empty($banks)) {
            foreach ($banks as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = $value->name;
                $nestedData['created_by'] = $value->createdBy->first()->name ;
                $nestedData['actions'] = '<div class="">
                    <a href=" ' . route('banks.edit', $value->id) . ' " title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-success">
                            <i class="fa fa-edit btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <button class="mr-2 btn-icon btn-icon-only btn btn-danger btn-delete" data-remote=" ' . route('banks.destroy', $value->id) . ' " title="Delete">
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'name.required' => 'Bank Name is Required.',
        );
        $this->validate($request, array(
            'name' => 'required',
        ), $messages);

        try {

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


            $data = new bank();

            $data->name = $request->name;
            $data->created_by = $auth->id;
            $data->admin_id = $parent_admin_id;

            $data->save();

            return redirect()
                ->route('banks.index')
                ->with('success', 'Created Successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounts\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounts\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        try {
            return view('account.bank.edit', compact('bank'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Accounts\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {

        $messages = array(
            'name.required' => 'Name is Required.',
        );
        $this->validate($request, array(
            'name' => 'required',
        ), $messages);

        try {

            $bank->name = $request->name;
            $bank->updated_by = $request->updated_by;

            $bank->update();

            return redirect()
                ->route('banks.index')
                ->with('success', 'Updated Successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounts\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
    }
}
