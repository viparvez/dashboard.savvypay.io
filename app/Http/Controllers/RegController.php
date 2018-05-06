<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
Use App\Address;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RegController extends Controller
{
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function addUser(Request $request) {

    	$this->validator($request->all())->validate();

    	if ($request->hasFile('logo')) {

    		$file = $request->file('logo');
			$image_name = "pp".time();
			$file->move('public/uploads', $image_name.'.jpg');
			$logo_url = 'public/uploads/'.$image_name.'.jpg';
			//$image = Image::make(sprintf('uploads/%s', $image_name))->resize(200, 200)->save();
		    
		} else {
			$logo_url = 'uploads/default.jpg';
		}


    	DB::beginTransaction();

			try {
			    $lastInsertId = DB::table('users')->insertGetId(
				    [
				    	'name' => $request->name, 
				    	'email' => $request->email, 
				    	'password' => bcrypt($request->password), 
				    	'active' => $request->active, 
				    	'userdeleted' => '0',
				    	'createdbyuser_id' => Auth::User()->id,
				    	'updatedbyuser_id' => Auth::User()->id,
				    	'created_at' => date('Y-m-d h:i:s'),
				    	'updated_at' => date('Y-m-d h:i:s')
				    ]
				);

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
				    	'user_id' => $lastInsertId,
				    	'logo_url' => $logo_url,
				    	'created_at' => date('Y-m-d h:i:s'),
				    	'updated_at' => date('Y-m-d h:i:s')
				    ]
				);

			    DB::commit();


			    notify()->flash('User Added', 'success', [
				    'timer' => 3000,
				    'text' => 'New user added successfully.',
				]);

				return redirect('/adduser');

			} catch (\Exception $e) {

			    DB::rollback();
			    
			    throw $e;
			}
    }


    public function updateUser( Request $request, $id) {
    	
    	DB::beginTransaction();

    	try {
			    DB::table('users')->where('id',$id)
			    	->update(
				    [
				    	'active' => $request->active, 
				    	'userdeleted' => '0',
				    	'updatedbyuser_id' => Auth::User()->id,
				    	'updated_at' => date('Y-m-d h:i:s')
				    ]
				);

				DB::table('addresses')->where('user_id',$id)
					->update(
				    [
				    	'line1' => $request->line1, 
				    	'line2' => $request->line2, 
				    	'po' => $request->po, 
				    	'pocode' => $request->pocode,
				    	'area' => $request->area,
				    	'city' => $request->city,
				    	'country' => $request->country,
				    	'phone' => $request->phone,
				    	'updated_at' => date('Y-m-d h:i:s')
				    ]
				);

			    DB::commit();


			    notify()->flash('Updated', 'success', [
				    'timer' => 3000,
				    'text' => 'User info updated successfully',
				]);

				return redirect('/users');

			} catch (\Exception $e) {

			    DB::rollback();
			    
			    throw $e;
			}


    }


}
