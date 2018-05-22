<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
                ->select('users.id','users.name','users.email', 'users.active', 'users.created_at', 'addresses.phone', 'addresses.image', 'addresses.line1', 'addresses.line2', 'addresses.po', 'addresses.pocode', 
                    'addresses.area', 'addresses.city', 'addresses.country' )
                ->leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
                ->where(['users.deleted'=>0])
                ->get();
        return view('layouts.pages.users', compact('users'));
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
            'name' => 'required|Regex:/^[\D]+$/i|max:70',
            'username' => 'required|Regex:/^[\D]+$/i|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            $id = DB::table('users')->insertGetId(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password'   => bcrypt($request->password),
                    'active' => '1',
                    'deleted' => '0',
                    'image' => url('/')."/public/images/users/demo.jpg",
                    'createdbyuser_id' => Auth::user()->id,
                    'updatedbyuser_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );

            /*foreach ($request->role as $key => $value) {
                DB::table('role_user')->insert([
                    'user_id' => $id,
                    'role_id' => $value,
                ]);
            }*/

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $name = $id.'.'.$file->getClientOriginalExtension();
                $file->move('public/uploads', $name.'.jpg');
                $image = 'public/uploads/'.$name.'.jpg';
                
            } else {
                $image = 'uploads/default.jpg';
            }

            User::where(['id' => $id])->update(
                [
                    'img_url' => url('/')."/public/images/users/".$name,
                ]
            );


            DB::commit();

            return response()->json(['success'=>'Added new records.']);            
   
        } catch (\Exception $e) {

          DB::rollback();
          echo $e->getMessage();
          return response()->json(['error'=>array('Could not add user')]);

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
        //
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
