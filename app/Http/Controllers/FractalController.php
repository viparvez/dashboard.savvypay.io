<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Transformers\TransactionTransformer;

use Fractal;
use JWTAuth;
use App\Transaction;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\DB;

class FractalController extends Controller
{
    
	public function index() {

		$user = JWTAuth::toUser(JWTAuth::getToken());

		$transactions = Transaction::where(['user_id' => $user->id, 'trxndeleted' => '0'])->get();
		
    	$transactions = fractal($transactions, new TransactionTransformer())->toArray();

		return response()->json($transactions);

    }

}
