<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Methodtype;
use Validator;
use Auth;

class MethodtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Methodtype::all();
        return view('layouts.pages.listmethodtype', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);
        }

        try {

            Methodtype::create(
                [
                    'name' => $request->name,
                    'active' => $request->active,
                    'createdbyuser_id' => Auth::user()->id,
                    'updatedbyuser_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );

            return response()->json(['success'=>'Record updated.']);


        } catch (\Exception $e) {
            return $e->getMessage();
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
        $type = Methodtype::where(['id' => $id])->first();

        if (!empty($type)) {
            $data = "
                <div class='box box-primary' style='font-weight:bold'>
                    <div class='box-body box-profile'>
                        <table class='table table-striped details-view'>
                            <tr>
                                <td>Name:</td><td>{$type->name}</td>
                            </tr>
                        </table>
                        <a onclick=show(\"".route('methodtypes.edit',$id)."\") class='btn btn-primary btn-block'><b>Edit</b></a>
                    </div>
                </div>
            ";

            return $data;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = Methodtype::where(['id' => $id])->first();

        $data = "
            <div class='modal-body'>
                <form method='POST' id='editForm' action='".route('methodtypes.update',$id)."'>
                ".csrf_field()."
                  <input type='hidden' name='_method' value='PUT'>

                  <div class='form-group'>
                    <label for='name'>Name:</label>
                    <input type='text' name='name' class='form-control' required='' placeholder='Name' value='{$type->name}'>
                  </div>
                  <div class='form-group'>
                    <label>Status</label>
                    <select name='status' class='form-control'>
                        <option value='1' ".($type->active == '1' ? 'selected' : '')."> ACTIVE </option>;
                        <option value='0' ".($type->active == '0' ? 'selected' : '')."> INACTIVE </option>;
                    </select>
                  </div>
                  <button class='btn btn-block btn-success btn-sm' id='submitEdit' type='submit'>SAVE</button>
                  <button class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</button>
                </form>
              </div>
        ";

        return $data;
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

            'name' => 'required',

        ]);


        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);
        }

        try {

            Methodtype::where(['id' => $id])->update(
                [
                    'name' => $request->name,
                    'active' => $request->status,
                    'updatedbyuser_id' => Auth::user()->id,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );

            return response()->json(['success'=>'Record updated.']);


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
