<?php

namespace App\Http\Controllers;


use App\Transaction;
use App\User;
Use App\Address;
use App\Refund;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Settlement;
use App\settlementrule;
use App\methodtype;
use App\Gateway;
use App\merchantrule;
use App\Settlementdetail;
use Barryvdh\DomPDF\Facade as PDF;
//use NIKPDF as PDF;

class PagesController extends Controller
{
	// Returns the index/home page
    public function index() {
    	return view('layouts.pages.home');
    }

    public function transactions() {
        $transactions = Transaction::where(['trxndeleted' => '0'])->get();
        return view('layouts.pages.transactions', compact('transactions'));
    }

    public function addUserView() {
		return view('layouts.pages.adduser');    	
    }

    public function listUsers() {
        $users = DB::table('users')
                ->select('users.id','users.name','users.email', 'users.active', 'users.created_at', 'addresses.phone', 'addresses.logo_url', 'addresses.line1', 'addresses.line2', 'addresses.po', 'addresses.pocode', 
                    'addresses.area', 'addresses.city', 'addresses.country' )
                ->leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
                ->where(['userdeleted'=>0])
                ->get();
        return view('layouts.pages.listusers', compact('users'));
    }

    public function setlView() {
        $settlements = Settlement::where(['deleted' => '0'])->get();
        $users = User::whereIn('id', function($query) {
            $query->select(['user_id']); 
            $query->distinct('user_id');
            $query->from('transactions');
        })->get();
        return view('layouts.pages.settlements',compact('settlements', 'users'));
    }

    public function refReq() {
        return view('layouts.pages.refund1');
    }

    public function listRefunds() {
        $refunds = Refund::all();
        return view('layouts.pages.refundlist', compact('refunds'));
    }

    public function getLogin() {
        return view('layouts.pages.login');
    }

    public function getRegister() {
        return redirect()->route('login');
    }

    public function settlementrules() {
        $methodtypes = methodtype::all();
        $rules = settlementrule::where(['deleted' => '0'])->get();
        return view('layouts.pages.settlementrules', compact('rules','methodtypes'));
    }

    public function methodtype() {
        $types = methodtype::all();
        return view('layouts.pages.listmethodtype', compact('types'));
    }

    public function gateways() {
        $gateways = Gateway::all();
        return view('layouts.pages.gateways', compact('gateways'));
    }

    public function merchantrule() {
        $users = DB::select("
                                SELECT
                                    *
                                FROM
                                    users
                                WHERE
                                    userdeleted = '0'
                                AND id NOT IN (
                                    SELECT DISTINCT
                                        (users.id)
                                    FROM
                                        users
                                    INNER JOIN merchantrules ON merchantrules.user_id = users.id
                                    WHERE
                                        merchantrules.deleted = '0'
                                )
                            ");

        $availed_users = User::with('Merchantrule')
            ->select('users.name','users.id')
            ->distinct('users.id')
            ->join('merchantrules', 'merchantrules.user_id', '=', 'users.id')
            ->where(['merchantrules.deleted' => '0'])
            ->get();


        $methodtypes = methodtype::all();
        $merchantrules = merchantrule::where(['deleted' => '0']);
        return view('layouts.pages.merchantrule',compact('methodtypes','merchantrules','users','availed_users'))->with(['controller'=>$this]);

    }

    public static function MerchantRuleForUser($user_id, $methodtype_id) {

        /*
        $var = DB::SELECT(
                "SELECT settlementrules.id FROM merchantrules 
                INNER JOIN settlementrules ON settlementrules.id = merchantrules.rule_id
                WHERE merchantrules.user_id = $user_id
                AND settlementrules.methodtype_id = $methodtype_id"
            );

        json_encode($var);
        return $var[0]['id'];
        */

        $var = Merchantrule::join('settlementrules', 'settlementrules.id', '=', 'merchantrules.rule_id')
               ->where(['merchantrules.user_id' => $user_id, 'settlementrules.methodtype_id' => $methodtype_id])
               ->select('merchantrules.rule_id')
               ->get();
        $id = (int)$var[0]->rule_id;
        echo $id;
    }


    public function showInvoice($invCode) {
        $code = sprintf('%08d', $invCode);
        $settlementdetails = Settlementdetail::where(['invCode' => $code])->get();
        return view('layouts.pages.invoicepdf', compact('settlementdetails'));
        //return $settlementdetails[0]->Settlement->estim_setldate;

    }


    public function downLoadPDF($invCode) {
        $code = sprintf('%08d', $invCode);
        $settlementdetails = Settlementdetail::where(['invCode' => $code])->get();
        $user = User::where(['id' => $settlementdetails[0]->User->id])->get();
        $pdf = PDF::loadView('layouts.pages.downloadinv', compact('settlementdetails','user') );
        return $pdf->setPaper('a4')->setWarnings(false)->download("invoice-$code.pdf");
    }

}