<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComponentImport;
use App\Exports\ComponentExport;
use Response;

class ComponentController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
    $data = Component::all();
    return view('inventory.component.index',compact('data'));
}

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
    return view('inventory.component.create');
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
            'component_code.required' => 'Component Code is Required.',
            'component_name.required' => 'Component Name is Required.',
        );
        $this->validate($request, array(
            'component_code' => 'required|unique:components,component_code,NULL,id,deleted_at,NULL',
            'component_name' => 'required|unique:components,component_name,NULL,id,deleted_at,NULL',
        ), $messages);

    $component_name =  $request->input('component_name', []);
    $component_code =  $request->input('component_code', []);

    foreach ($component_name as $index => $unit) {$data[] = [
        "component_name" => $component_name[$index],
        "component_code" => $component_code[$index]
    ];
}

    $created = Component::insert($data);
    return redirect('components')->with('success', 'Data updated successfully completed');
}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
    $value = Component::find($id);
    return view('inventory.component.show',compact('value'));
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
    $data = Component::find($id);
    return view('inventory.component.update',compact('data'));
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
        'component_code.required' => 'Component Code is Required.',
        'component_name.required' => 'Component Name is Required.',
    );
    $this->validate($request, array(
        'component_code' => 'required|unique:components,component_code,NULL,id,deleted_at,NULL' .$id,
        'component_name' => 'required|unique:components,component_name,NULL,id,deleted_at,NULL' .$id,
    ), $messages);

    $data = Component::find($id);
    $data->component_name = $request->component_name;
    $data->component_code = $request->component_code;
    $data->update();

    return redirect('components')->with('success', 'Data updated successfully completed');
}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
    $del = Component::find($id);
    if ($del) {
        $del->delete();
        return back()->with('success', 'Data deleted successfully completed');
    } else {
        return back()->with('error', 'Data not deleted');
    }
}

public function export(){
    return view('inventory.component.export');
}

public function importdata() {
    return Excel::download(new ComponentExport, 'component.xlsx');
}
public function filedownload() {
        return 'Response'::download('csv/sample.xlsx', 'sample.xlsx');
}

public function exportdata(){

    $data = Excel::import(new ComponentImport, request()->file('file'));
    if($data){
         return redirect('components')->with('success', 'File export successfully completed');
    }else{
        return back()->with('error','File not exported');
    }
}


}
