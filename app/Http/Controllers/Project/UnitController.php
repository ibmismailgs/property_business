<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $data = Unit::all();
        return view('projects.unit.index',compact('data'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view ('projects.unit.create');
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
            'unit_name.required' => 'Unit Name is Required.',
        );
        $this->validate($request, array(
            'unit_name' => 'required|unique:units,unit_name,NULL,id,deleted_at,NULL',
        ), $messages);

        $data=new Unit();
        $data->unit_name=$request->input('unit_name');
        $data->status=$request->input('status')==true?'1':'0';
        $data->save();

        return redirect('package-unit')->with('success', 'Data insert successfully completed');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $data=Unit::find($id);
        return view('projects.unit.show',compact('data'));}

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $data=Unit::find($id);
        return view('projects.unit.update',compact('data'));
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
            'unit_name.required' => 'Unit Name is Required.',
        );
        $this->validate($request, array(
            'unit_name' => 'required|unique:units,unit_name,NULL,id,deleted_at,NULL' .$id,
        ), $messages);

        $data= Unit::find($id);
        $data->unit_name=$request->input('unit_name');
        $data->status=$request->input('status')==true?'1':'0';
        $data->update();

        return redirect('package-unit')->with('success', 'Data updated successfully completed');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {

        $del = Unit::find($id);
        if ($del) {
            $del->delete();
            return redirect('package-unit')->with('success', 'Data deleted successfully completed');
        } else {
            return redirect()->back()->with('error', 'Data not deleted');
        }
    }
}
