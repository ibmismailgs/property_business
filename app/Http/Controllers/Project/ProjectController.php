<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProjectType;
use App\Models\Project;
use App\Models\Component;
use App\Models\ProjectComponentDetail;
use Carbon;

class ProjectController extends Controller
{
    public function index()
{
    $projects = Project::all();
    return view('projects.project.index',compact('projects'));
}

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
    $data = ProjectType::where('project_status', 1)->get();
    $component  = Component::all();
    return view('projects.project.create',compact('data', 'component'));
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
            'project_type_id.required' => 'Please select a project type',
            'project_name.required' => 'Project Name is Required.',
            'project_packages.required' => 'Number of Packages is Required.',
            'project_value.required' => 'Projects Value is Required.',
            'project_duration.required' => 'Projects Duration is Required.',
            'implementing_agency.required' => 'Implementing Agency is Required.',
            'start_date.required' => 'Start Date is Required.',
            'completed_date.required' => 'Completed Date is Required.',
            'component_id.required' => 'Please select a component',
            'gob.required' => 'GOB is Required.',
            'others_rpa.required' => 'Others RPA is Required.',
            'dpa.required' => 'DPA is Required.',
        );

        $this->validate($request, array(
            'project_type_id' => 'required',
            'project_name' => 'required|unique:projects,project_name,NULL,id,deleted_at,NULL',
            'project_packages' => 'required',
            'project_value' => 'required',
            'project_duration' => 'required',
            'implementing_agency' => 'required',
            'start_date' => 'required',
            'completed_date' => 'required',
            'component_id' => 'array',
            'gob' => 'array',
            'others_rpa' => 'array',
            'dpa' => 'array',
        ), $messages);

    try{
        $data = $request->all();
        $project = Project::create($data);
        foreach($request->component_id as $key => $id){
                        $components['project_id'] = $project->id;
                        $components['component_id'] = $id;
                        $components['gob'] = $request->gob[$key];
                        $components['others_rpa'] = $request->others_rpa[$key];
                        $components['dpa'] = $request->dpa[$key];
                        $components['total'] = $request->total[$key];
            ProjectComponentDetail::insert($components);
        }
        return redirect('projects')->with('success', 'Data inserted successfully completed');
    } catch (\Exception $e) {
        $bug = $e->getMessage();
        return redirect()->back()->with('error', $bug);
    }
}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
    $projects = Project::with('components')->find($id);
     return view('projects.project.show',compact('projects'));
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
    $projects = Project::find($id);
    $projecttypes = ProjectType::where('project_status', 1)->get();
    $components = Component::all();
    return view('projects.project.update',compact('projects','projecttypes','components'));
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
            'project_type_id.required' => 'Please select a project type',
            'project_name.required' => 'Project Name is Required.',
            'project_packages.required' => 'Number of Packages is Required.',
            'project_value.required' => 'Projects Value is Required.',
            'project_duration.required' => 'Projects Duration is Required.',
            'implementing_agency.required' => 'Implementing Agency is Required.',
            'start_date.required' => 'Start Date is Required.',
            'completed_date.required' => 'Completed Date is Required.',
            'component_id.required' => 'Please select a component',
            'gob.required' => 'GOB is Required.',
            'others_rpa.required' => 'Others RPA is Required.',
            'dpa.required' => 'DPA is Required.',
        );

        $this->validate($request, array(
            'project_type_id' => 'required',
            'project_name' => 'required|unique:projects,project_name,NULL,id,deleted_at,NULL' .$id,
            'project_packages' => 'required',
            'project_value' => 'required',
            'project_duration' => 'required',
            'implementing_agency' => 'required',
            'start_date' => 'required',
            'completed_date' => 'required',
            'component_id' => 'array',
            'gob' => 'array',
            'others_rpa' => 'array',
            'dpa' => 'array',
        ), $messages);

        $data = $request->all();
        try{
            $project = Project::findOrFail($id);
            $project->update($data);
            foreach($request->component_id as $key => $component){
                $syncData[$component] = [
                    'gob' => $request->gob[$key] ?? '',
                    'others_rpa' => $request->others_rpa[$key] ?? '',
                    'dpa' => $request->dpa[$key] ?? '',
                    'total' => $request->total[$key] ?? '',
                ];
            }
            $project->components()->sync($syncData);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
        return redirect('projects')->with('success', 'Data updated successfully completed');
}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
   $project = Project::find($id);
   if($project){
    $project->delete();
    foreach($project->componentdetails as $component){
        $component->deleted_at = Carbon\Carbon::now();
        $component->update();
        return back()->with('success', 'Data successfully deleted');
    }
   }

}

public function packageShow()
{
    $result = ProjectType::has('projects')->with('projects')->get();
    return view('projects.project.packageShow',compact('result'));
}

}
