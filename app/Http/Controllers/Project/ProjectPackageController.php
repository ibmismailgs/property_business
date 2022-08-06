<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProjectPackage;
use App\Models\PackageType;
use App\Models\Project;
use App\Models\Contactor;
use App\Models\SubContactor;
use DB;

class ProjectPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $data = ProjectPackage::all();
        return view('projects.project_packages.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Project::all();
        $contactor = Contactor::all();
        $package = PackageType::where('status',1)->get();
        return view('projects.project_packages.create',compact('data','contactor','package'));
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
            'type_id.required' => 'Please select a package type',
            'contactor_id.required' => 'Choose a contactor name',
            'contactor_type.required' => 'Choose a contactor type',
            'package_name.required' => 'Package Name is Required.',
            'package_number.required' => 'Package Number is Required.',
            'package_duration.required' => 'Package Duration is Required.',
            'package_start_date.required' => 'Package Start Date is Required.',
            'package_end_date.required' => 'Package End Date is Required.',
        );
        $this->validate($request, array(
            'project_id' => 'required',
            'type_id' => 'required',
            'contactor_id' => 'required',
            'contactor_type' => 'required',
            'package_name' => 'required|unique:project_packages,package_name,NULL,id,deleted_at,NULL',
            'package_number' => 'required',
            'package_duration' => 'required',
            'package_start_date' => 'required',
            'package_end_date' => 'required',
        ), $messages);

        $data= new ProjectPackage();
        $data->project_id=$request->input('project_id');
        $data->type_id=$request->input('type_id');
        $data->contactor_id=$request->input('contactor_id');
        $data->contactor_type=$request->input('contactor_type');
        $data->package_name=$request->input('package_name');
        $data->package_number=$request->input('package_number');
        $data->package_duration=$request->input('package_duration');
        $data->package_start_date=$request->input('package_start_date');
        $data->package_end_date=$request->input('package_end_date');
        $data->save();

        return redirect('project-packages')->with('success', 'Data insert successfully completed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $value=ProjectPackage::find($id);
        return view('projects.project_packages.show',compact('value'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ProjectPackage::find($id);
        $project = Project::all();
        $contactor = Contactor::all();
        $package = PackageType::where('status', 1)->get();
        return view('projects.project_packages.update',compact('data','project','contactor','package'));
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
            'project_id.required' => 'Please select a project',
            'type_id.required' => 'Please select a package type',
            'contactor_id.required' => 'Choose a contactor name',
            'contactor_type.required' => 'Choose a contactor type',
            'package_name.required' => 'Package Name is Required.',
            'package_number.required' => 'Package Number is Required.',
            'package_duration.required' => 'Package Duration is Required.',
            'package_start_date.required' => 'Package Start Date is Required.',
            'package_end_date.required' => 'Package End Date is Required.',
        );
        $this->validate($request, array(
            'project_id' => 'required',
            'type_id' => 'required',
            'contactor_id' => 'required',
            'contactor_type' => 'required',
            'package_name' => 'required|unique:project_packages,package_name,NULL,id,deleted_at,NULL' .$id,
            'package_number' => 'required',
            'package_duration' => 'required',
            'package_start_date' => 'required',
            'package_end_date' => 'required',
        ), $messages);

        $data = ProjectPackage::find($id);
        $data->project_id=$request->input('project_id');
        $data->type_id=$request->input('type_id');
        $data->contactor_id=$request->input('contactor_id');
        $data->contactor_type=$request->input('contactor_type');
        $data->package_name=$request->input('package_name');
        $data->package_number=$request->input('package_number');
        $data->package_duration=$request->input('package_duration');
        $data->package_start_date=$request->input('package_start_date');
        $data->package_end_date=$request->input('package_end_date');
        $data->update();

        return redirect('project-packages')->with('success', 'Data updated successfully completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = ProjectPackage::find($id);
        if ($del) {
            $del->delete();
            return redirect('project_packages')->with('success', 'Data deleted successfully completed');
        } else {
            return back()->with('error', 'Data not deleted');
        }
    }

}
