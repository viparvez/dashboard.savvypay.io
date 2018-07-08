<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Settlementrule;
use App\Methodtype;
use Validator;
use Auth;

class SettlementruleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $methodtypes = Methodtype::all();
        $rules = Settlementrule::where(['deleted' => '0'])->get();
        return view('layouts.pages.settlementrules', compact('rules','methodtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:70',
            'methodtype_id' => 'required',
            'bill_policy' => 'required',
            'amount' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            Settlementrule::create($input);

            DB::commit();
            
            return response()->json(['success'=>'Added new records.']);         
        
        } catch (\Exception $e) {

          DB::rollback();
          echo $e->getMessage();
          return response()->json(['error'=>array('Could not create new rule')]);

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
        $settlementrule = Settlementrule::where(['id' => $id])->first();

        return "
            <div class='box box-primary' style='font-weight:bold'>
                <div class='box-body box-profile'>

                  <table class='table table-striped details-view'>
                    <tr>
                      <td>Name</td><td>$settlementrule->name</td>
                    </tr>
                    <tr>
                      <td>Method type</td><td>".$settlementrule->Methodtype->name."</td>
                    </tr>

                    <tr>
                      <td>Bill Policy</td><td>$settlementrule->bill_policy</td>
                    </tr>

                    <tr>
                      <td>Amount</td><td>".sprintf('%0.2f', $settlementrule->amount)."</td>
                    </tr>
                  </table>

                  <a onclick=show(\"".route('settlementrules.edit',$id)."\") class='btn btn-primary btn-block'><b>Edit</b></a>
                </div>
              </div>
        ";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settlementrule = Settlementrule::where(['id' => $id])->first();

        $methodtypeOps = "";

        $methodtypes = Methodtype::where(['active' => '1'])->get();

        foreach ($methodtypes as $key => $value) {
            if ($settlementrule->methodtype_id == $value->id) {
                $methodtypeOps .= "<option value='$value->id' selected>$value->name</option>";
            } else {
                $methodtypeOps .= "<option value='$value->id'>$value->name</option>";
            }
        }

        return "
            <div class='modal-body'>
                <form method='POST' id='editForm' action='".route('settlementrules.update',$id)."'>
                ".csrf_field()."
                  <input type='hidden' name='_method' value='PUT'>

                  <div class='form-group'>
                    <label for='name'>Name:</label>
                    <input type='text' name='name' class='form-control' required='' placeholder='Name' value='{$settlementrule->name}'>
                  </div>

                  <div class='form-group'>
                    <label>Methodtype</label>
                    <select name='methodtype_id' class='form-control'>
                        $methodtypeOps
                    </select>
                  </div>

                  <div class='form-group'>
                    <label>Bill Policy</label>
                    <select name='bill_policy' class='form-control'>
                        <option value='AMOUNT' ".($settlementrule->bill_policy == 'AMOUNT' ? 'selected' : '').">$settlementrule->bill_policy</option>;
                        <option value='PERCENTAGE' ".($settlementrule->bill_policy == 'PERCENTAGE' ? 'selected' : '')."> $settlementrule->bill_policy</option>;
                    </select>
                  </div>

                  <div class='form-group'>
                    <label for='amount'>Amount:</label>
                    <input type='text' name='amount' class='form-control' required='' placeholder='Amount' value='{$settlementrule->amount}'>
                  </div>


                  <button class='btn btn-block btn-success btn-sm' id='submitEdit' type='submit'>SAVE</button>
                  <button class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</button>
                </form>
            </div>
        ";
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
            'name' => 'required|max:70',
            'methodtype_id' => 'required',
            'bill_policy' => 'required',
            'amount' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            Settlementrule::where(['id' => $id])->update(
                [
                    'name' => $request->name,
                    'methodtype_id' => $request->methodtype_id,
                    'bill_policy' => $request->bill_policy,
                    'amount' => $request->amount,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );

            DB::commit();
            
            return response()->json(['success'=>'Record updated.']);         
        
        } catch (\Exception $e) {

          DB::rollback();
          echo $e->getMessage();
          return response()->json(['error'=>array('Could not update')]);

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
