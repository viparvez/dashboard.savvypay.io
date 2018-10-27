<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ipndetail;
use Validator;
use App\User;
use Auth;


class IpnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where(['id' => Auth::user()->id])->first();
        $user_id = Auth::user()->id;

        $merchantapiusers = $user->Merchantuserapi($user_id);
        
        return view('layouts.pages.ipn', compact('merchantapiusers'));
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

            'api_user_id' => 'required|numeric',
            'email' => 'nullable|email',
            'web_service_url' => 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'

        ]);


        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $hasEntry = Ipndetail::where(['api_user_id' => $request->api_user_id])->first();

        if (!empty($hasEntry)) {
            return response()->json(['error'=>array('Duplicate entry for the same api user is not possible.')]);
        }


        DB::beginTransaction();

        try {

            DB::table('ipndetails')->insert(
                [
                    'api_user_id' => $request->api_user_id,
                    'web_service_url' => $request->web_service_url,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'comment' => $request->comment,
                    'createdbyuser_id' => Auth::user()->id,
                    'updatedbyuser_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );
            
            DB::commit();

            return response()->json(['success'=>'Record updated.']);


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e->getMessage()]);
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
        $ipn = Ipndetail::where(['api_user_id' => $id])->first();

        if (is_null($ipn)) {
            $form = view('layouts.pages.templates.ipn-form', compact('id'));
        } else {
            $form = view('layouts.pages.templates.update-ipn', compact('ipn', 'id'));
        }

        return $form;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

            'email' => 'nullable|email',
            'web_service_url' => 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'

        ]);


        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);
        }


        DB::beginTransaction();

        try {

            Ipndetail::where(['api_user_id' => $id])->update(
                [
                    'web_service_url' => $request->web_service_url,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'comment' => $request->comment,
                    'updatedbyuser_id' => Auth::user()->id,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );

            DB::commit();

            return response()->json(['success'=>'Record updated.']);


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e->getMessage()]);
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
