<?php

namespace App\Http\Controllers;

use App\Refund;
use App\Transaction;
use Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function refReq(Request $request) {
    	$trxnnum = $request->trxnnum;
		$transactions = Transaction::where(['trxnnum' => $trxnnum])->get();
		return view('layouts.pages.refund2', compact('transactions'));
	}  

	public function postrefreq(Request $request) {
		
		$refundrequest = new Refund();

		try{

			$refundrequest->transaction_id = $request['transaction_id'];
			$refundrequest->created_at = date('Y-m-d h:i:s');
			$refundrequest->updated_at = date('Y-m-d h:i:s');
			$refundrequest->createdbyuser_id = Auth::user()->id;
			$refundrequest->updatedbyuser_id = Auth::user()->id;
			$refundrequest->refd_amount = 'NULL';

			$refundrequest->save();

			notify()->flash('Request Submitted', 'success', [
				'timer' => 3000,
				'text' => 'Your request has been submitted successfully.',
			]);

			return redirect('/requestarefund');

		}
		catch (\Exception $e){

			notify()->flash('Request Denied', 'error', [
				'timer' => 10000,
				'text' => 'Either this transaction does not exist or it has already been requested!',
			]);

			return redirect('/requestarefund');

		}
		

	}
}
