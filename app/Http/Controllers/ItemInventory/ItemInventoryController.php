<?php

namespace App\Http\Controllers\ItemInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryCategory;
use App\Models\InventorySubCategory;
use App\Models\InventoryGroup;
use App\Models\ItemInventory;
use App\Models\InventoryItem;

class ItemInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $item = ItemInventory::with('category')->get();
        $item = ItemInventory::all();
        return view('item_inventory.item.index',compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = InventoryCategory::where('status', 1)->get();
        $item = InventoryItem::all();
        $subcategory = InventorySubCategory::all();
        $group = InventoryGroup::where('status', 1)->get();
        return view('item_inventory.item.create',compact('item','subcategory','category','group'));
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
            'category_id.required' => 'Please select a category',
            // 'subcategory_id.required' => 'Please select a sub-category',
            // 'group_id.required' => 'Please select a group name',
            'item_id.required' => 'Please select an item',
        );
        $this->validate($request, array(
            'category_id' => 'required',
            // 'subcategory_id' => 'required',
            // 'group_id' => 'required',
            'item_id' => 'required',
        ), $messages);

        $data = new ItemInventory();
        $data->category_id=$request->category_id;
        $data->subcategory_id=$request->subcategory_id;
        $data->group_id=$request->group_id;
        $data->item_id=$request->item_id;
        $data->save();

        return redirect('item-inventory')->with('success', 'Data insert successfully completed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $value = ItemInventory::find($id);
        return view('item_inventory.item.show',compact('value'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = ItemInventory::find($id);
        $itemname = InventoryItem::all();
        $category = InventoryCategory::where('status', 1)->get();
        $subcategory = InventorySubCategory::all();
        $group = InventoryGroup::where('status', 1)->get();

        return view('item_inventory.item.update',compact('item', 'itemname','category','subcategory','group'));
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
        $messages = array(
            'category_id.required' => 'Please select a category',
            // 'subcategory_id.required' => 'Please select a sub-category',
            // 'group_id.required' => 'Please select a group name',
            'item_id.required' => 'Please select an item',
        );
        $this->validate($request, array(
            'category_id' => 'required',
            // 'subcategory_id' => 'required',
            // 'group_id' => 'required',
            'item_id' => 'required',
        ), $messages);

        $data = ItemInventory::find($id);
        $data->category_id=$request->category_id;
        $data->subcategory_id=$request->subcategory_id;
        $data->group_id=$request->group_id;
        $data->item_id=$request->item_id;
        $data->update();

        return redirect('item-inventory')->with('success', 'Data updated successfully completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = ItemInventory::find($id);
        if ($del) {
            $del->delete();
            return back()->with('success', 'Data deleted successfully completed');
        } else {
            return back()->with('error', 'Data not deleted');
        }
    }
    public function subcategory(Request $request)
    {
        $category_id = $request->category_id;
        $subcategory = InventorySubCategory::with('category')->where('category_id', $category_id)->get();
        return response()->json([
            'subcategory' => $subcategory
        ]);
    }
}
