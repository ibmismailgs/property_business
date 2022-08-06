<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryGroup;
use DB;

class InventoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = InventoryGroup::all();
        return view('inventory.group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = array(
            'group_name.required' => 'Inventory Group  Name is Required',
        );
        $this->validate($request, array(
            'group_name' => 'required|unique:inventory_groups,group_name,NULL,id,deleted_at,NULL',
        ), $message);

        $group= new InventoryGroup();
        $group->group_name=$request->group_name;
        $group->status=$request->status == true?'1':'0';
        $group->save();

        return redirect('inventory-group')->with('success', 'Data insert succesfully completed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = InventoryGroup::find($id);
        return view('inventory.group.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = InventoryGroup::find($id);
        return view('inventory.group.update', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = array(
            'group_name.required' => 'Inventory Group  Name is Required',
        );
        $this->validate($request, array(
            'group_name' => 'required|unique:inventory_groups,group_name,NULL,id,deleted_at,NULL' .$id,
        ), $message);

        $group= InventoryGroup::find($id);
        $group->group_name=$request->group_name;
        $group->status=$request->status == true?'1':'0';
        $group->update();

        return redirect('inventory-group')->with('success', 'Data update succesfully completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = InventoryGroup::find($id);
        if ($group) {
            $group->delete();
            return back()->with('success', 'Data deleted successfully completed');
        } else {
            return back()->with('error', 'Data not deleted');
        }
    }
}
