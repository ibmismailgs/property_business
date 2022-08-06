<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Unit;
use App\Models\ProjectPackage;
use App\Models\Item;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $item = Item::all();
        return view('projects.items.index',compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = ProjectPackage::all();
        $unit = Unit::where('status', 1)->get();
        return view('projects.items.create',compact('unit','package'));
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
            'package_id.required' => 'Please select a package',
            'unit_id.required' => 'Please choose an unit',
            'item_name.required' => 'Item name is Required.',
            'item_rate.required' => 'Item rate is Required.',
            'item_code.required' => 'Item code is Required.',
            'item_quantity.required' => 'Item quantity is Required.',
        );
        $this->validate($request, array(
            'package_id' => 'required',
            'unit_id' => 'required',
            'item_name' => 'required|unique:items,item_name,NULL,id,deleted_at,NULL',
            'item_rate' => 'required|numeric',
            'item_code' => 'required',
            'item_quantity' => 'required|numeric',
        ), $messages);

        $data= new Item();
        $data->package_id=$request->input('package_id');
        $data->unit_id=$request->input('unit_id');
        $data->item_name=$request->input('item_name');
        $data->item_rate=$request->input('item_rate');
        $data->item_code=$request->input('item_code');
        $data->item_quantity=$request->input('item_quantity');
        $data->total_cost=$request->input('total_cost');
        $data->save();

        return redirect('package-items')->with('success', 'Data insert successfully completed');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $value=Item::find($id);
        return view('projects.items.show',compact('value'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $unit = Unit::where('status', 1)->get();
        $package = ProjectPackage::all();
        return view('projects.items.update',compact('package','unit','item'));
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
            'package_id.required' => 'Please select a package',
            'unit_id.required' => 'Please choose an unit',
            'item_name.required' => 'Item name is Required.',
            'item_rate.required' => 'Item rate is Required.',
            'item_code.required' => 'Item code is Required.',
            'item_quantity.required' => 'Item quantity is Required.',
        );
        $this->validate($request, array(
            'package_id' => 'required',
            'unit_id' => 'required',
            'item_name' => 'required|unique:items,item_name,NULL,id,deleted_at,NULL' .$id,
            'item_rate' => 'required|numeric',
            'item_code' => 'required',
            'item_quantity' => 'required|numeric',
        ), $messages);


        $data=Item::find($id);
        $data->package_id=$request->input('package_id');
        $data->unit_id=$request->input('unit_id');
        $data->item_name=$request->input('item_name');
        $data->item_rate=$request->input('item_rate');
        $data->item_code=$request->input('item_code');
        $data->item_quantity=$request->input('item_quantity');
        $data->total_cost=$request->input('total_cost');
        $data->update();

        return redirect('package-items')->with('success', 'Data updated successfully completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Item::find($id);
        if ($del) {
            $del->delete();
            return redirect('package-items')->with('success', 'Data deleted successfully completed');
        } else {
            return redirect()->with('error', 'Data not deleted');
        }
    }
}
