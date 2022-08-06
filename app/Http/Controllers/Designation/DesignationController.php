<?php

namespace App\Http\Controllers\Designation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Designation;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Designation::all();
        return view('designation.index',compact('data'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view ('designation.create');
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
            'name.required' => 'Designation field is required',
        );
        $this->validate($request, array(
            'name' => 'required|unique:designations,name,NULL,id,deleted_at,NULL',
        ), $messages);

            $data= new Designation();
            $data->name=$request->input('name');
            $data->status = $request->input('status');
            $data->save();
            return redirect('designation')->with('success', 'Data insert successfully completed');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $data = Designation::find($id);
        return view('designation.show',compact('data'));}

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $data = Designation::find($id);
        return view('designation.update',compact('data'));
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
            'name.required' => 'Designation field is required',
        );
        $this->validate($request, array(
            'name' => 'required|unique:designations,name,NULL,id,deleted_at,NULL' .$id,
        ), $messages);

        $data = Designation::find($id);
        $data->name=$request->input('name');
        $data->status=$request->input('status')==true?'1':'0';
        $data->update();

        return redirect('designation')->with('success', 'Data updated successfully completed');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $del = Designation::find($id);
        if ($del) {
            $del->delete();
            return redirect('designation')->with('success', 'Data deleted successfully completed');
        } else {
            return redirect('designation')->with('error', 'Data not deleted');
        }
    }
}
