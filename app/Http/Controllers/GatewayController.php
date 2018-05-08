<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Gateway;
use Auth;

class GatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gateways = Gateway::paginate(25);
        return view('layouts.pages.gateways', compact('gateways'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gateway = Gateway::where(['id' => $id])->first();

        if (!empty($gateway)) {
            $data = "
                <div class='box box-primary' style='font-weight:bold'>
                    <div class='box-body box-profile'>
                        <table class='table table-striped details-view'>
                            <tr>
                                <td>Name:</td><td>{$gateway->name}</td>
                            </tr>
                        </table>
                        <a onclick=show(\"".route('gateways.edit',$id)."\") class='btn btn-primary btn-block'><b>Edit</b></a>
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
        $gateway = Gateway::where(['id' => $id])->first();

        $data = "
            <div class='modal-body'>
                <form method='POST' action='".route('gateways.update',$id)."'>
                ".csrf_field()."
                  <div class='form-group'>
                    <label for='name'>Name:</label>
                    <input type='text' name='name' class='form-control' required='' placeholder='Name'>
                  </div>
                  <button class='btn btn-sm btn-info'>SAVE</button>
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
        //
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
