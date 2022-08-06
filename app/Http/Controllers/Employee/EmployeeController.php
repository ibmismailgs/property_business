<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Project;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all();
        return view('employees.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Designation::where('status', 1)->get();
        return view('employees.create',compact('data'));
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
            'designation_id.required' => 'Please select a designation',
            'first_name.required' => 'First name is Required',
            'last_name.required' => 'Last name phone is required',
            'father_name.required' => 'Father name is required',
            'mother_name.required' => 'Mother name is required',
            'email.required' => 'Email field is required',
            'phone.required' => 'Phone number is required',
            'gender.required' => 'Choose your gender',
            'birthday.required' => 'Birthday is required',
            'joining_date.required' => 'joining date is required',
            'address.required' => 'Address is required',
        );

        $this->validate($request, array(
            'designation_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'joining_date' => 'required',
            'address' => 'required',
        ), $messages);

        $data= new Employee();
        $data->designation_id=$request->input('designation_id');
        $data->first_name=$request->input('first_name');
        $data->last_name=$request->input('last_name');
        $data->father_name=$request->input('father_name');
        $data->mother_name=$request->input('mother_name');
        $data->email=$request->input('email');
        $data->phone=$request->input('phone');
        $data->gender=$request->input('gender');
        $data->birthday=$request->input('birthday');
        $data->joining_date=$request->input('joining_date');
        $data->address=$request->input('address');
        $data->save();

        return redirect('employees')->with('success', 'Successfully completed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $value = Employee::find($id);
        return view('employees.show',compact('value'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Employee::find($id);
        $designation = Designation::where('status', 1)->get();
        return view('employees.update',compact('data','designation'));
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
            'designation_id.required' => 'Desigantion field is required',
            'first_name.required' => 'First name is Required',
            'last_name.required' => 'Last name phone is required',
            'father_name.required' => 'Father name is required',
            'mother_name.required' => 'Mother name is required',
            'email.required' => 'Email field is required',
            'phone.required' => 'Phone number is required',
            'gender.required' => 'Choose your gender',
            'birthday.required' => 'Birthday is required',
            'joining_date.required' => 'Joining date is required',
            'address.required' => 'Address is required',
        );

        $this->validate($request, array(
            'designation_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'joining_date' => 'required',
            'address' => 'required',
        ), $messages);

        $data = Employee::find($id);
        $data->designation_id=$request->input('designation_id');
        $data->first_name=$request->input('first_name');
        $data->last_name=$request->input('last_name');
        $data->father_name=$request->input('father_name');
        $data->mother_name=$request->input('mother_name');
        $data->email=$request->input('email');
        $data->phone=$request->input('phone');
        $data->gender=$request->input('gender');
        $data->birthday=$request->input('birthday');
        $data->joining_date=$request->input('joining_date');
        $data->address=$request->input('address');;
        $data->update();

        return redirect('employees')->with('success', 'Data updated successfully completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Employee::find($id);
        if ($del) {
            $del->delete();
            return redirect('employees')->with('success', 'Data deleted successfully completed');
        } else {
            return back()->with('error', 'Data not deleted');
        }
    }
    public function assign(){
        $project= Project::all();
        $employee= Employee::all();
        return view('assign.create',compact('project','employee'));
    }
    public function assignup(){
        $project= Project::all();
        $employee= Employee::all();
        return view('assign.update',compact('project','employee'));
    }
}
