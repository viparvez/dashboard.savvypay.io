<?php

namespace App\Http\Controllers;

use JWTAuth;


use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Settlement;
use App\methodtype;
use App\Gateway;

class PaymentController extends Controller
{
    public function create(Request $request) {


    	$user = JWTAuth::toUser(JWTAuth::getToken());
        $trxnnum = date('Ymd.his');

    	if(isset($request->methodtype_name)) {
    		$methodtype = methodtype::where(['name' => $request->methodtype_name])->first();
    		
    		if(empty($methodtype)) {
    			$data = array(
							'code' => '010',
							'message' => 'Incorrect Payment Method.'
						);

				return json_encode($data);
				break;
    		} else {
    			$methodtype_id = $methodtype->id;
    		}
    		
    	} else {
    		$data = array(
							'code' => '011',
							'message' => 'Payment method not provided.'
						);

				return json_encode($data);
				break;
    	}


    	if(isset($request->amount)) {
    		
    		if($request->amount <= 0 || $request->amount >= 1000000) {
    			$data = array(
							'code' => '012',
							'message' => 'Invalid Amount'
						);

				return json_encode($data);
				break;
    		} else {

                if (gettype($request->amount) != 'double') {
                    $data = array(
                            'message' => "Invalid data type: '".gettype($request->amount)."' for amount. Require 'double' type value.",
                        );

                    return json_encode($data);
                    break;
                } else {
                    $amount = $request->amount;
                }

    		}
    		
    	} else {
    		$data = array(
							'code' => '013',
							'message' => 'Amount not provided.'
						);

				return json_encode($data);
				break;
    	}

    	

    	if(isset($request->gateway)) {
    		$gateway = Gateway::where(['name' => $request->gateway, 'active' => '1'])->first();
    		
    		if(empty($gateway)) {
    			$data = array(
							'code' => '014',
							'message' => 'Incorrect Gateway Service Provider.'
						);

				return json_encode($data);
				break;
    		} else {
    			$gateway_id = $gateway->id;
    		}

    	} else {
    		$gateway_id = 15;
    	}


    	if(isset($request->ipn_url)) {
    		
    		$ipn_url = $request->ipn_url;

    	} else {
    		$ipn_url = 'http://api.savvypay.io/';
    	}



    	if(isset($request->unique_id)) {
    		$unique_id = $request->unique_id;
    		
    		if(empty($unique_id) || (strlen($unique_id) < 16 || strlen($unique_id) > 24)) {
    			$data = array(
							'code' => '015',
							'message' => 'Incorrect unique ID. The unique ID should be at least a 16-24 charecter alpha-numeric string and should be globally unique.'
						);

				return json_encode($data);
				break;
    		} else {

                if (ctype_alnum($request->unique_id)) {

                    $duplicate = Transaction::where(['clientunique_id' => $request->unique_id])->first();

                    if(empty($duplicate)) {

                        $unique_id = $request->unique_id;

                    } else {

                        $data = array(
                                'code' => '016',
                                'message' => 'Unique ID already exist'
                            );

                        return json_encode($data);
                        break;
                    }

                } else {

                    $data = array(
                                'code' => '017',
                                'message' => 'No special character allowed in unique ID.'
                            );

                    return json_encode($data);
                    break;

                }

    		}

    	} else {
    		$data = array(
							'code' => '018',
							'message' => 'Unique ID not provided. The unique ID should be at least a 16-24 character alpha-numeric string and should be globally unique.'
						);

			return json_encode($data);
			break;
    	}



    	if(isset($request->reference)) {
    		
    		$reference = $request->reference;

    	} else {
    		$reference = null ;
    	}
    	

			DB::beginTransaction();

			try{

				$trxnId = DB::table('transactions')->insertGetId(
				    [
				    	'trxnnum' => $trxnnum,
			    		'clientunique_id' => $unique_id,
			    		'user_id' => $user->id,
			    		'amount' => $amount,
			    		'callback_url' => $ipn_url,
			    		'gateway_id' => $gateway_id,
			    		'gatewaytrxn_id' => null,
			    		'reference' => $reference,
			    		'created_at' => date('Y-m-d h:i:s'),
				    	'updated_at' => date('Y-m-d h:i:s'),
			    		'trxndeleted' => '0',
			    		'methodtype_id' => $methodtype_id
				    ]
				);
				

				DB::commit();

				$data = array(
							'code' => '201',
							'message' => 'Payment request created successfully.',
                            'trxn_num' => $trxnnum,
							'load_url' => 'https://epay.thecitybank.com/index.jsp?ORDERID=4162488&SESSIONID=AF1BD2752A057E57C4F7E887BA35119E',
						);

				return json_encode($data);

			} catch(\Exception $e) {

				DB::rollback();
			    
			    throw $e;
			}


    }



    public function index() {

        $user = JWTAuth::toUser(JWTAuth::getToken());

    	$transactions = Transaction::where(['createdbyuser_id' => $user->id])->get();

	    return $transactions;

    }

}
