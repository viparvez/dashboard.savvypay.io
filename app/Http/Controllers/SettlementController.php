<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Settlement;
use Auth;

class SettlementController extends Controller
{
    public function settle(Request $request) {

    	$id = $request->settlement_id;

    	try{

    		$query = DB::table('settlements')->where('id',$id)
				->update(
					[
					'status' => 'PROCESSED',
					'updated_at' => date('Y-m-d h:i:s'),
					'note' => $request->note
					]
				);

			notify()->flash('Settled', 'success', [
				'timer' => 3000,
				'text' => 'Payment has been settled!',
			]);

			return redirect('/settlements');

    	} catch (\Exception $e) {

    		notify()->flash('Error', 'error', [
				'timer' => 3000,
				'text' => 'Please contact the admin!',
			]);

			return redirect('/settlements');

    	}

    }

}
