<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\Employee;
use App\Models\ProjectAssign;

class ProjectAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $data = ProjectAssign::all();
        return view('projects.project_assign.index',compact('data'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        // $data = ProjectAssign::all();
        $employee = Employee::all();
        $project = Project::all();
        return view ('projects.project_assign.create',compact('project','employee'));
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
            'project_id.required' => 'Please select a project',
            'employee_id.required' => 'Please choose an employee',
        );
        $this->validate($request, array(
            'project_id' => 'required',
            'employee_id' => 'required',
        ), $messages);

        $data = new ProjectAssign();
        $data->project_id=$request->input('project_id');
        $data->employee_id=$request->input('employee_id');
        $data->save();

        return redirect('project-assign')->with('success', 'Data insert successfully completed');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $data = ProjectAssign::find($id);
        // $data = ProjectAssign::with('projects')->find($id);
        return view('projects.project_assign.show',compact('data'));}
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $data = ProjectAssign::find($id);
        $project = Project::all();
        $employee = Employee::all();
        return view('projects.project_assign.update',compact('data','project','employee'));
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
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'employee_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = ProjectAssign::find($id);
        $data->project_id=$request->input('project_id');
        $data->employee_id=$request->input('employee_id');
        $data->update();

        return redirect('project-assign')->with('success', 'Data updated successfully completed');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {

        $del = ProjectAssign::find($id);
        if ($del) {
            $del->delete();
            return redirect('project-assign')->with('success', 'Successfully data deleted.');
        } else {
            return redirect()->back()->with('error', 'Data not deleted');
        }
    }
}
