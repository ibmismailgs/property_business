<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PackageType;

class PackageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PackageType::all();
        return view('projects.package_type.index',compact('data'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view ('projects.package_type.create');
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
            'name.required' => 'Package type name is required',
        );
        $this->validate($request, array(
            'name' => 'required|unique:package_types,name,NULL,id,deleted_at,NULL',
        ), $messages);

            $data= new PackageType();
            $data->name =$request->name;
            $data->status = $request->status;
            $data->save();
            return redirect('package-type')->with('success', 'Data insert successfully completed');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $data=PackageType::find($id);
        return view('projects.package_type.show',compact('data'));}

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $data = PackageType::find($id);
        return view('projects.package_type.update',compact('data'));
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
            'name.required' => 'Package type name is required',
        );
        $this->validate($request, array(
            'name' => 'required|unique:package_types,name,NULL,id,deleted_at,NULL' .$id,
        ), $messages);

        $data=PackageType::find($id);
        $data->name=$request->input('name');
        $data->status=$request->input('status')==true?'1':'0';
        $data->update();

        return redirect('package-type')->with('success', 'Data successfully updated');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $del = PackageType::find($id);
        if ($del) {
            $del->delete();
            return redirect('package-type')->with('success', 'Data deleted successfully completed');
        } else {
            return redirect()->back()->with('error', 'Data not deleted');
        }
    }
}
