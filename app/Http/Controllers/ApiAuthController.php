<?php

namespace App\Http\Controllers;

use JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
		$credentials['active'] = 1;
       	$credentials['userdeleted'] = 0;

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
}
