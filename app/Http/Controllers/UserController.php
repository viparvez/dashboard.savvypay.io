<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\User;
use App\Address;
use Auth;

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
        $merchants = User::where(['api_user' => '1'])->get();
        return view('layouts.pages.users', compact('users','merchants'));
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
            'username' => 'required|Regex:/^[\D]+$/i|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'line1' => 'required',
            'po' => 'required',
            'pocode' => 'required',
            'area' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required|numeric|unique:addresses',
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
                    'username' => $request->username,
                    'password'   => bcrypt($request->password),
                    'api_user' => $request->api_user,
                    'merchant_user_id' => $request->merchant_user_id,
                    'active' => '1',
                    'deleted' => '0',
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

            DB::table('addresses')->insert(
                [
                    'line1' => $request->line1,
                    'line2' => $request->line2,
                    'po' => $request->po,
                    'pocode' => $request->pocode,
                    'area' => $request->area,
                    'city' => $request->city,
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'user_id' => $id,
                    'image' => url('/')."/public/uploads/".$name,
                    'createdbyuser_id' => Auth::user()->id,
                    'updatedbyuser_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
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
        $user = User::where(['id' => $id])->first();

        if(is_null($user->merchant_user_id)) {
            $merchant = "";
        } else {
            $merchant = "
                    <tr>
                      <td>Merchant</td><td>".$user->Merchant->name."</td>
                    </tr>
            ";
        }

        $data = "
            <div class='box box-primary' style='font-weight:bold'>
                <div class='box-body box-profile'>

                <img class='profile-user-img img-responsive img-responsive' src='".$user->Address->image."' alt='Picture'>

                  <table class='table table-striped details-view'>
                    <tr>
                      <td>Name</td><td>$user->name</td>
                    </tr>
                    <tr>
                      <td>Username</td><td>$user->username</td>
                    </tr>

                    <tr>
                      <td>Email</td><td>$user->email</td>
                    </tr>

                    <tr>
                      <td>Phone</td><td>".$user->Address->phone."</td>
                    </tr>

                    <tr>
                      <td>Country</td><td>".$user->Address->country."</td>
                    </tr>

                    <tr>
                      <td>City</td><td>".$user->Address->city."</td>
                    </tr>

                    <tr>
                      <td>Area</td><td>".$user->Address->area."</td>
                    </tr>

                    <tr>
                      <td>Postal Code</td><td>".$user->Address->pocode."</td>
                    </tr>

                    <tr>
                      <td>Address Line 1</td><td>".$user->Address->line1."</td>
                    </tr>

                    <tr>
                      <td>Address Line 2</td><td>".$user->Address->line2."</td>
                    </tr>

                    ".$merchant."
                    
                    <tr>
                      <td>Active</td><td>".($user->active == '1' ? 'YES' : 'NO')."</td>
                    </tr>

                    <tr>
                      <td>API User?</td><td>".($user->api_user == '1' ? 'YES' : 'NO')."</td>
                    </tr>

                  </table>

                  <a onclick=show(\"".route('users.edit',$id)."\") class='btn btn-primary btn-block'><b>Edit</b></a>
                </div>
              </div>
        ";


        return $data;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where(['id' => $id])->first();

        $merchants = User::where(['api_user' => '1'])->get();

        

        if (!empty($user->merchant_user_id)) {

            $merchantOps = "<div class='form-group' id='merchantOps'>
                                <label for='country'>Merchant Account:</label>
                                <select class='form-control' name='merchant_user_id'>
                                <option value=''>SELECT</option>";

            foreach ($merchants as $key => $value) {
                if ($value->id == $user->merchant_user_id) {
                    $merchantOps .= "<option value='".$value->id."' selected>".$value->name."</option>";
                } else {
                    $merchantOps .= "<option value='".$value->id."'>".$value->name."</option>";
                }
            }

            $merchantOps .= "</select></div>";

        } else {
            $merchantOps = "";
        }

        $form = "
            <div class='modal-body'>
            
            <form method='POST' id='editForm' action='".route('users.update',$id)."' enctype='multipart/form-data'>
            ".csrf_field()."
            <input type='hidden' name='_method' value='PUT'>

            <div class='col-md-6 col-xs-12'>
              <div class='form-group'>
                <label for='name'>Full Name:</label>
                <input type='text' name='name' class='form-control' required='' placeholder='Name' value='".$user->name."'>
              </div>

              <div class='form-group'>
                <label for='email'>Email:</label>
                <input type='text' name='email' class='form-control' required='' placeholder='Email' value='".$user->email."'>
              </div>

              <div class='form-group'>
                <label for='username'>Username:</label>
                <input type='text' name='username' class='form-control' required='' placeholder='Username' value='".$user->username."' disabled>
              </div>

              <div class='form-group'>
                <label for='status'>Status:</label>
                <select class='form-control' name='active'>
                  <option value='1' ".($user->active == '1' ? 'selected' : '').">Active</option>
                  <option value='0' ".($user->active == '0' ? 'selected' : '').">Inactive</option>
                </select>
              </div>
              
                ".$merchantOps."

              <div class='form-group'>
                <label for='phone'>Phone:</label>
                <input type='phone' name='phone' class='form-control' required='' placeholder='Phone' value='".$user->Address->phone."'>
              </div>

              <div class='form-group'>
                <label for='address'>Address Line 1:</label>
                <input type='text' name='line1' class='form-control' required='' placeholder='Address Line 1' value='".$user->Address->line1."'>
              </div>


            </div>
              
            <div class='col-md-6 col-xs-12'>

              <div class='form-group'>
                <label for='address'>Address Line 2:</label>
                <input type='text' name='line2' class='form-control' required='' placeholder='Address Line 2' value='".$user->Address->line2."'>
              </div>

              <div class='form-group'>
                <label for='post office'>Post Office:</label>
                <input type='text' name='po' class='form-control' required='' placeholder='Post Office' value='".$user->Address->po."'>
              </div>

              <div class='form-group'>
                <label for='postal code'>Postal Code:</label>
                <input type='text' name='pocode' class='form-control' required='' placeholder='Postal Code' value='".$user->Address->pocode."'>
              </div>

              <div class='form-group'>
                <label for='area'>Area:</label>
                <input type='text' name='area' class='form-control' required='' placeholder='Area' value='".$user->Address->area."'>
              </div>

              <div class='form-group'>
                <label for='city'>City:</label>
                <input type='text' name='city' class='form-control' required='' placeholder='City' value='".$user->Address->city."'>
              </div>

              <div class='form-group'>
                <label for='country'>Country:</label>
                <select class='form-control' name='country'>
                  <option value='Bangladesh' selected>Bangladesh</option>
                </select>
              </div>

              <div class='form-group'>
                <label>Image</label>
                <input type='file' name='image' id='image' >
              </div>

            </div>

            <button class='btn btn-block btn-success btn-sm' id='submitEdit' type='submit'>SAVE</button>
            <button class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</button>
            </form>
          </div>
        ";

        return $form;
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
            'name' => 'required|Regex:/^[\D]+$/i|max:70',
            'email' => 'required|email|unique:users,email,'.$id,
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'line1' => 'required',
            'po' => 'required',
            'pocode' => 'required',
            'area' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $user = User::where(['id' => $id])->first();

        DB::beginTransaction();

        try {

            User::where(['id' => $id])->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'active' => $request->active,
                    'updatedbyuser_id' => Auth::user()->id,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $name = $id.'.'.$file->getClientOriginalExtension();
                $file->move('public/uploads', $name.'.jpg');
                $image = 'public/uploads/'.$name.'.jpg';
                
            } else {
                $image = $user->Address->image;
            }

            Address::where(['user_id' => $id])->update(
                [
                    'line1' => $request->line1,
                    'line2' => $request->line2,
                    'po' => $request->po,
                    'pocode' => $request->pocode,
                    'area' => $request->area,
                    'city' => $request->city,
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'image' => $image,
                    'updatedbyuser_id' => Auth::user()->id,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );


            DB::commit();

            return response()->json(['success'=>'User updated.']);            
        
        } catch (\Exception $e) {

          DB::rollback();
          echo $e->getMessage();
          return response()->json(['error'=>array('Could not update user')]);

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
