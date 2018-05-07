<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gateway;
use App\methodtype;
use App\Settlement;
use App\settlementrule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\merchantrule;


class SettingsController extends Controller
{
    public function SaveMethodtype(Request $request) {

    	$input = $request->all();
    	$create = methodtype::create($input);

    	if ($create) {
    		notify()->flash('Done', 'success', [
				'timer' => 3000,
				'text' => 'New Method Type Created.',
			]);
    	} else {
    		notify()->flash('Error', 'error', [
				'timer' => 3000,
				'text' => 'Something Went Wrong',
			]);
    	}

    	return redirect()->route('methodtype');

    }

    public function SaveGateway(Request $request) {

    	$input = $request->all();
    	$create = Gateway::create($input);

    	if ($create) {
    		notify()->flash('Done', 'success', [
				'timer' => 3000,
				'text' => 'New  Gateway Created.',
			]);
    	} else {
    		notify()->flash('Error', 'error', [
				'timer' => 3000,
				'text' => 'Something Went Wrong',
			]);
    	}

        return redirect()->route('gateways');

    }


    public function UpdateGateway(Request $request) {

        $update = Gateway::findorfail($request->id);
        $update->bill_policy = $request->bill_policy;
        $update->amount = $request->amount;
        $update->save();

        if ($update) {
            notify()->flash('Done', 'success', [
                'timer' => 3000,
                'text' => 'Update was successful.',
            ]);
        } else {
            notify()->flash('Error', 'error', [
                'timer' => 3000,
                'text' => 'Something Went Wrong',
            ]);
        }

        return redirect()->route('gateways');

    }


    public function UpdateSettlementrules(Request $request) {

        $update = settlementrule::findorfail($request->id);
        $update->update($request->all());

        if ($update) {
            notify()->flash('Done', 'success', [
                'timer' => 3000,
                'text' => 'Update was successful.',
            ]);
        } else {
            notify()->flash('Error', 'error', [
                'timer' => 3000,
                'text' => 'Something Went Wrong',
            ]);
        }

            return redirect()->route('settlementrules');

    }



    public function saveSettlementrules(Request $request) {

            $input = $request->all();
            $create = settlementrule::create($input);

            if ($create) {
                notify()->flash('Done', 'success', [
                    'timer' => 3000,
                    'text' => 'New Settlement Rule Created.',
                ]);
            } else {
                notify()->flash('Error', 'error', [
                    'timer' => 3000,
                    'text' => 'Something Went Wrong',
                ]);
            }

            return redirect()->route('settlementrules');

    }


    public function createSettlement(Request $request) {

    	$input = $request->all();
    	$user_id = $request->user_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

    	//$estim_setldate = date('d-m-Y',strtotime("+7 day"));
        
        if($end_date < $start_date) {
            
            notify()->flash('End date can not be older than start date', 'error');

            return redirect()->route('setlView');

        }


    	function generateInvCode() {
        	$invID = Settlement::orderBy('created_at', 'desc')->first();
        	$invID = $invID->id + 1;
        	$invoiceCode = sprintf('%08d', $invID);
        	return $invoiceCode;
        }

        $invCode = generateInvCode();

        $results = DB::select(
        	"
				SELECT 
                    MethodID AS ID,
                    MethodTypeName AS Gateway,
                    SUM(Total) AS TotalAmount,
                    ChargableValue AS Charge,
                    SUM(ChargedAmount) AS ChargedAmount,
                    round(
                        SUM(Total) - SUM(ChargedAmount),
                        2
                    ) AS CreditableAmount
                FROM
                (
                SELECT
                    method.id AS MethodID,
                    method.name AS MethodTypeName,
                    trxn.amount AS Total,
                    setlrule.bill_policy AS BillingPolicy,
                    setlrule.amount AS ChargableValue,
                    setlrule.name AS SettlementRuleName,
                    CASE WHEN setlrule.bill_policy = 'PERCENTAGE' THEN round(((trxn.amount*setlrule.amount)/100),2)
                             WHEN setlrule.bill_policy = 'AMOUNT' THEN round(((setlrule.amount*1)),2)
                             ELSE NULL
                             END AS ChargedAmount
                FROM
                    transactions trxn
                INNER JOIN methodtypes method ON method.id = trxn.methodtype_id
                INNER JOIN (
                    SELECT
                        settlementrules.*, merchantrules.id AS user_id
                    FROM
                        settlementrules
                    INNER JOIN merchantrules ON merchantrules.rule_id = settlementrules.id
                    WHERE merchantrules.user_id = '$user_id'
                    AND merchantrules.deleted = '0'
                    AND settlementrules.deleted = '0'
                        
                ) setlrule ON setlrule.methodtype_id = method.id
                WHERE
                    trxn.created_at BETWEEN '$start_date 00:00:00'
                AND '$end_date 23:59:59'
                AND trxn.user_id = '$user_id'
                ) SavvyPay
                GROUP BY MethodTypeName
        	"
        	);

        if ($results == '') {
        	return $results->count();
        }


        $total = 0;
        $totalChargable = 0;
        $totalCreditable = 0;

        foreach ($results as $result) {
        	$total += $result->TotalAmount;
        	$totalChargable += $result->ChargedAmount;
        	$totalCreditable += $result->CreditableAmount;

        	$SettlementDetails[] = [
        								'invCode' => $invCode, 
        								'methodtype_id' => $result->ID,
        								'user_id' => $user_id,
        								'TotalAmount' => $result->TotalAmount,
        								'Charge' => $result->ChargedAmount,
        								'CreditableAmount' => $result->CreditableAmount,
        								'created_at' => date('Y-m-d h:i:s'),
				    					'updated_at' => date('Y-m-d h:i:s')
        							];
        }

        $Settlement[] =  [
			        		'invCode' => $invCode,
			        		'GrandTotalAmount' => $total,
			        		'TotalChargable' => $totalChargable,
			        		'TotalCreditable' => $totalCreditable,
			        		'user_id' => $user_id,
			        		'estim_setldate' => date('Y-m-d',strtotime("+7 day")),
			        		'status' => 'REQUESTED',
			        		'created_at' => date('Y-m-d h:i:s'),
			        		'updated_at' => date('Y-m-d h:i:s')
			        	];
        

        DB::beginTransaction();

        try {

        	DB::table('settlements')->insert($Settlement);

        	DB::table('settlementdetails')->insert($SettlementDetails);

        	DB::commit();

    	    notify()->flash('Settlement Request Created', 'success', [
    		    'timer' => 3000,
    		    'text' => 'Settlement Request Created',
    		]);

    		return redirect()->route('setlView');

        } catch (\Exception $e) {
        	DB::rollback();
        	throw $e;
        }
        

        //return $SettlementDetails;

    }


    public function saveMerchantrule(Request $request) {

    	$input = $request->all();

    	$rows = $input['rows'];

    	for ($i = 0; $i < count($rows); $i++) {

    		$rules[] = [
    						'deleted' => '0',
    						'rule_id' => $rows[$i]['rule_id'],
    						'user_id' => $input['user_id'],
    						'created_at' => date('Y-m-d h:i:s'),
			        		'updated_at' => date('Y-m-d h:i:s')
    				];
    	}


    	$create = DB::table('merchantrules')->insert($rules);

    	if ($create) {
    		notify()->flash('Done', 'success', [
				'timer' => 3000,
				'text' => 'Rule Assigned',
			]);
    	} else {
    		notify()->flash('Error', 'error', [
				'timer' => 3000,
				'text' => 'Something Went Wrong',
			]);
    	}

        return redirect()->route('merchantrule');

    }



    public function updateMerchantrule(Request $request) {
    	    	$input = $request->all();
                $id = $request->user_id;
    	    	$update = DB::table('merchantrules')
                          ->where('user_id', $id)
                          ->update(['deleted' => '1']);

    	    	if ($update) {
    	    		notify()->flash('Deleted', 'success', [
    					'timer' => 3000,
    					'text' => 'Rule Deleted',
    				]);
    	    	} else {
    	    		notify()->flash('Error', 'error', [
    					'timer' => 3000,
    					'text' => 'Something Went Wrong',
    				]);
    	    	}

    	        return redirect()->route('merchantrule');

    }


}
