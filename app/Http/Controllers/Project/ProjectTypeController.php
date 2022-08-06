<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProjectType;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProjectType::all();
        return view('projects.project_type.index',compact('data'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view ('projects.project_type.create');
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
            'type_name.required' => 'Project Type Name is Required.',
        );
        $this->validate($request, array(
            'type_name' => 'required|unique:project_types,type_name,NULL,id,deleted_at,NULL',
        ), $messages);

            $data = new ProjectType();
            $data->type_name = $request->type_name;
            $data->project_status = $request->project_status == true? '1':'0';
            $data->save();

            return redirect('project-type')->with('success', 'Data insert successfully completed');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $data=ProjectType::find($id);
        return view('projects.project_type.show',compact('data'));}

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $data=ProjectType::find($id);
        return view('projects.project_type.update',compact('data'));
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
            'type_name.required' => 'Project Type Name is Required.',
        );
        $this->validate($request, array(
            'type_name' => 'required|unique:project_types,type_name,NULL,id,deleted_at,NULL' .$id,
        ), $messages);

            $data=ProjectType::find($id);
            $data->type_name=$request->input('type_name');
            $data->project_status=$request->input('project_status') == true?'1':'0';
            $data->update();

            return redirect('project-type')->with('success', 'Data updated successfully completed');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $delete = ProjectType::find($id);
        if ($delete) {
            $delete->delete();
            return redirect('project-type')->with('success', 'Successfully data deleted');
        } else {
            return redirect()->back()->with('error', 'Data not deleted');
        }
    }
}
