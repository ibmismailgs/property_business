<?php

namespace App\Http\Controllers\Contactor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contactor;

class ContactorController extends Controller
{
    public function index()
    {
        $contactors = Contactor::all();
        return view('contactors.contactor.index',compact('contactors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contactors.contactor.create');
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
            'contactor_name.required' => 'Contactor name is required',
            'contactor_email.required' => 'Contactor email is Required',
            'contactor_phone.required' => 'Contactor phone is required',
            'contactor_address.required' => 'Contactor address is required',
        );
        $this->validate($request, array(
            'contactor_name' => 'required|unique:contactors,contactor_name,NULL,id,deleted_at,NULL',
            'contactor_email' => 'required',
            'contactor_phone' => 'required',
            'contactor_address' => 'required',
        ), $messages);

            $data= new Contactor();
            $data->contactor_name=$request->input('contactor_name');
            $data->contactor_email=$request->input('contactor_email');
            $data->contactor_phone=$request->input('contactor_phone');
            $data->contactor_address=$request->input('contactor_address');
            $data->save();
            return redirect('contactors')->with('success', 'Data insert successfully completed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contactor = Contactor::find($id);
        return view('contactors.contactor.show',compact('contactor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contactor = Contactor::find($id);
        return view('contactors.contactor.update',compact('contactor'));
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
            'contactor_name.required' => 'Contactor name is required',
            'contactor_email.required' => 'Contactor email is Required',
            'contactor_phone.required' => 'Contactor phone is required',
            'contactor_address.required' => 'Contactor address is required',
        );
        $this->validate($request, array(
            'contactor_name' => 'required|unique:contactors,contactor_name,NULL,id,deleted_at,NULL' . $id,
            'contactor_email' => 'required',
            'contactor_phone' => 'required',
            'contactor_address' => 'required',
        ), $messages);

        $data = Contactor::find($id);
        $data->contactor_name= $request->input('contactor_name');
        $data->contactor_email=$request->input('contactor_email');
        $data->contactor_phone=$request->input('contactor_phone');
        $data->contactor_address=$request->input('contactor_address');
        $data->update();

        return redirect('contactors')->with('success', 'Data updated successfully completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Contactor::find($id);
        if ($del) {
            $del->delete();
            return redirect('contactors')->with('success', 'Data deleted successfully completed');
        } else {
            return redirect('contactors')->with('error', 'Data not deleted');
        }
    }
}
