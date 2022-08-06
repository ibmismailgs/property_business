<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryItem;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = InventoryItem::all();
        return view('inventory.items.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.items.create');
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
            'item_name.required' => 'Item Name is Required.',
            'item_price.required' => 'Item Price is Required.',
            'item_origin.required' => 'Item Origin is Required.',
        );
        $this->validate($request, array(
            'item_name' => 'required|unique:inventory_items,item_name,NULL,id,deleted_at,NULL',
            'item_price' => 'required',
            'item_origin' => 'required',
        ), $messages);

        $item= new InventoryItem();
        $item->item_name=$request->item_name;
        $item->item_price=$request->item_price;
        $item->item_origin=$request->item_origin;
        $item->save();

        return redirect('inventory-items')->with('success', 'Data insert successfully completed');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = InventoryItem::find($id);
        return view('inventory.items.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = InventoryItem::find($id);
        return view('inventory.items.update',compact('item'));
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
            'item_name.required' => 'Item Name is Required.',
            'item_price.required' => 'Item Price is Required.',
            'item_origin.required' => 'Item Origin is Required.',
        );
        $this->validate($request, array(
            'item_name' => 'required|unique:inventory_items,item_name,,NULL,id,deleted_at,NULL' .$id,
            'item_price' => 'required|numeric',
            'item_origin' => 'required',
        ), $messages);

        $item = InventoryItem::find($id);
        $item->item_name=$request->item_name;
        $item->item_price=$request->item_price;
        $item->item_origin=$request->item_origin;
        $item->update();

        return redirect('inventory-items')->with('success', 'Data updated successfully completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = InventoryItem::find($id);
        if ($item) {
            $item->delete();
            return redirect('inventory-items')->with('success', 'Data deleted successfully completed');
        } else {
            return redirect('inventory-items')->with('error', 'Data not deleted');
        }
    }
}
