<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventorySubCategory;
use App\Models\InventoryCategory;
use App\Repositories\Helper\ModeDataRepository;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Validation\Rule;
use DB;

class InventorySubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.subcategory.index');
    }


    //get inventory sub-category
    public function getInventorySubCategoryList(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'category_id',
            2 => 'name',
            3 => 'actions'
        );

        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        //Collect data according to role
        if ($user_role->name == 'Super Admin') {

            $totalData = $totalFiltered = InventorySubCategory::count();
        } elseif ($user_role->name == 'Admin') {

            //admin_id column has main admin id
            $totalData = $totalFiltered = InventorySubCategory::where('admin_id', $Auth->id)
                ->count();
        } else {

            //created_by column has main current user id
            $totalData = $totalFiltered = InventorySubCategory::where('created_by', $Auth->id)
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
                $accounts = InventorySubCategory::with('category')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();
            } elseif ($user_role->name == 'Admin') {
                $accounts = InventorySubCategory::with('category')
                    ->where('admin_id', $Auth->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();
            } else {
                $accounts = InventorySubCategory::with('category')
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
                $accounts = InventorySubCategory::with('category')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                //Collect total count value
                $totalFiltered = InventorySubCategory::with('category')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->count();
            } elseif ($user_role->name == 'Admin') {

                $accounts = InventorySubCategory::with('category')
                    ->where('admin_id', $Auth->id)
                    ->where(function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('admin_id', Auth::id()); //admin_id is auth
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = InventorySubCategory::with('bank')
                    ->where('admin_id', $Auth->id)
                    ->where(function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('category', function ($query) use ($search, $Auth) {
                        $query->where('admin_id', Auth::id()); //admin_id is auth
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->count();
            } else {
                $accounts = InventorySubCategory::with('category')
                    ->where('created_by', $Auth->id)
                    ->where(function ($query) use ($search, $Auth) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('category', function ($query) use ($search, $Auth) {
                        $query->where('created_by', Auth::id());
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->latest()
                    ->get();

                $totalFiltered = InventorySubCategory::with('category')
                    ->where('admin_id', $Auth->id)
                    ->where(function ($query) use ($search, $Auth) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })->count();
            }
        }

        //Display data
        $data = array();
        if (!empty($accounts)) {
            foreach ($accounts as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = $value->name;
                $nestedData['category_id'] = $value->category->first()->name;
                $nestedData['actions'] = '<div class="">
                    <a href=" ' . route('inventory-subcategory.show', $value->id) . ' " title="Show">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-info">
                            <i class="fa fa-eye btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a href=" ' . route('inventory-subcategory.edit', $value->id) . ' " title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-success">
                            <i class="fa fa-edit btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <button class="mr-2 btn-icon btn-icon-only btn btn-danger btn-delete" data-remote=" ' . route('inventory-subcategory.destroy', $value->id) . ' " title="Delete">
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
        $categories = $this->getCategoryAsRole();
        return view('inventory.subcategory.create', compact('categories'));
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
                'category_id.required' => 'Category Name is Required.',
                'name.required' => 'Sub-Category Name is Required.',
            );
            $this->validate($request, array(
                'category_id' => 'required',
                'name' => 'required',
            ), $messages);

            try {

                DB::transaction(function () use ($request) {
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

                    $data = new InventorySubCategory();
                    $data->category_id = $request->category_id;
                    $data->name = $request->name;
                    $data->created_by = $auth->id;
                    $data->admin_id = $parent_admin_id;
                    $data->save();
                });

                return redirect()
                    ->route('inventory-subcategory.index')
                    ->with('success', 'Created Successfully');
            } catch (\Exception $e) {

                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        dd($inventorysubcategory->name);
        return view('inventory.subcategory.show', compact('inventorySubCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(InventorySubCategory $inventorySubCategory)
    {
        try {
            $banks = $this->getCategoryAsRole();
            return view('inventory.subcategory.update', compact('categories', 'inventorySubCategory'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *
     */


    public function update(Request $request, InventorySubCategory $inventorySubCategory)
    {
        $messages = array(
            'category_id.required' => 'Category Name is Required.',
            'name.required' => 'Sub-Category Name is Required.',
        );
        $this->validate($request, array(
            'name' => 'required',
            'category_id' => 'required',
        ), $messages);

        try {

            $inventorySubCategory->category_id = $request->category_id;
            $inventorySubCategory->name = $request->name;
            $inventorySubCategory->updated_by = Auth::id();
            $inventorySubCategory->update();

            return redirect()
                ->route('inventory-subcategory.index')
                ->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(InventorySubCategory $inventorySubCategory)
    {
        $inventorySubCategory->delete();
    }

    //Get category Id and Name As User Role.
    public function getCategoryAsRole()
    {
        $Auth = Auth::user();
        $user_role = $Auth->roles->first();

        //Collect category name and id according to role
        if ($user_role->name == 'Super Admin') {

            //Super admin can get all category name
            $categories = InventoryCategory::get(['name', 'id']);
        } elseif ($user_role->name == 'Admin') {

            //collect category account id auth is admin.admin_id column has all admin id
            $categories = InventoryCategory::where('admin_id', $Auth->id)
                ->get(['name', 'id']);
        } else {

            //collect category account id auth is not an admin or super admin.created_by column has all current auth id
            $categories = InventoryCategory::where('admin_id', $Auth->parent_admin_id)
                ->get(['name', 'id']);
        }

        return $categories;
    }


}
