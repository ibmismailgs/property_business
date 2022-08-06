<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryCategory;
use App\Repositories\Helper\ModeDataRepository;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Validation\Rule;

class InventoryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.category.index');
    }


    //get inventory category
    public function getInventoryCategoryList(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'status',
            3 => 'created_by',
            4 => 'actions'
        );

        $authRole = UserRepository::authRole();
        $totalData = $totalFiltered = ModeDataRepository::countAsRole($authRole, InventoryCategory::class);

        if ($request->input('length') == -1) {
            $limit = $totalData;
        } else {
            $limit = $request->input('length');
        }

        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if (empty($request->input('search.value'))) {

            //Collect data according to role
            $results = ModeDataRepository::allDataAsRole($authRole, InventoryCategory::class, 'createdBy');
            $categories = $results->offset($start)->limit($limit)
                ->orderBy($order, $dir)
                ->latest()
                ->get();
        } else {

            //Collect search data according to role
            $search = $request->input('search.value');

            if ($authRole === 'Super Admin') {

                $results = InventoryCategory::with('createdBy')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    });

                $totalFiltered = $results->count();
            } elseif ($authRole === 'Admin') {

                $results = InventoryCategory::with('createdBy')
                    ->where('admin_id', Auth::id())
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search) {
                        $query->where('id', Auth::id());
                        $query->orWhere('parent_admin_id', Auth::id()); //all user under admin
                        $query->where('name', 'LIKE', "%{$search}%");
                    });

                $totalFiltered = $results->count();
            } else {
                $results = InventoryCategory::with('createdBy')
                    ->where('created_by', Auth::id())
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('createdBy', function ($query) use ($search) {
                        $query->where('id', Auth::id());
                        $query->where('name', 'LIKE', "%{$search}%");
                    });

                $totalFiltered = $results->count();
            }

            $categories = $results->offset($start)->limit($limit)
                ->orderBy($order, $dir)
                ->latest()
                ->get();
        }

        //Display data
        $data = array();
        if (!empty($categories)) {
            foreach ($categories as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = $value->name;
                $nestedData['status'] =  $value->status == '1' ? 'Active' : ($value->status == '0' ? 'Inactive' : '');
                $nestedData['created_by'] = $value->createdBy->name . ' - ' . '(' . UserRepository::userRole($value->createdBy->id) . ')';
                $nestedData['actions'] = '<div class="">

                <a href=" ' . route('inventory-category.show', $value->id) . ' " title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-primary">
                            <i class="fa fa-eye btn-icon-wrapper"></i>
                        </button>
                    </a>

                <a href=" ' . route('inventory-category.edit', $value->id) . ' " title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-success">
                            <i class="fa fa-edit btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <button class="mr-2 btn-icon btn-icon-only btn btn-danger btn-delete" data-remote=" ' . route('inventory-category.destroy', $value->id) . ' " title="Delete">
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
        try {
            $authRole = UserRepository::authRole();
            $category = ModeDataRepository::allDataAsRole($authRole, InventoryCategory::class)->get();
            return view('inventory.category.create', compact('category'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            'name.required' => 'Category name is Required.',
            'name.unique' => 'Category name already taken.',
        );
        $this->validate($request, array(
            'name' => [
                'required',
                Rule::unique('inventory_categories')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name)
                        ->where('created_by', Auth::id())
                        ->whereNull('deleted_at');
                })
            ],
        ), $messages);

        try {
            $authParentId = UserRepository::authParentId();
            $data = new InventoryCategory();
            $data->name = $request->name;
            $data->status = $request->status;
            $data->created_by = Auth::id();
            $data->admin_id = $authParentId;
            $data->save();

            return redirect()
                ->route('inventory-category.index')
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

    public function show(InventoryCategory $inventoryCategory)
    {
        return view('inventory.category.show', compact('inventoryCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryCategory $inventoryCategory)
    {
        try {
            return view('inventory.category.update', compact('inventoryCategory'));
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
     */

    public function update(Request $request, InventoryCategory $inventoryCategory)
    {
        $messages = array(
            'name.required' => 'Cateory Name is Required.',
        );
        $this->validate($request, array(
            'name' => [
                'required',
                Rule::unique('inventory_categories')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name)
                        ->where('created_by', Auth::id())
                        ->whereNull('deleted_at');
                })->ignore($inventoryCategory->id)
            ],
        ), $messages);

        try {

            $inventoryCategory->name = $request->name;
            $inventoryCategory->status = $request->status;
            $inventoryCategory->updated_by = Auth::id();
            $inventoryCategory->update();

            return redirect()
                ->route('inventory-category.index')
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
    public function destroy(InventoryCategory $inventoryCategory)
    {
        $inventoryCategory->delete();
    }
}
