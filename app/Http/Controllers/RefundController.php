<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use Session;
use App\Refund;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refunds = Refund::where(['refunddeleted' => '0'])->paginate(25);
        return view('layouts.pages.refundlist', compact('refunds'));
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
            'transaction_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            Refund::create(
                [
                    'transaction_id' => $request->transaction_id,
                    'refundnote' => $request->refundnote,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'createdbyuser_id' => Auth::user()->id,
                    'updatedbyuser_id' => Auth::user()->id,
                    'refunddeleted' => '0'
                ]
            );

            DB::commit();

            Session::flash('success', "Refund request sent.");

            return redirect()->route('refunds.index');

        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
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

    public function search(Request $request) {

        $validator = Validator::make($request->all(), [
            'trxnnum' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $trxnnum = $request->trxnnum;
        $transaction = DB::select(
            "
                SELECT
                    transactions.id,
                    transactions.trxnnum,
                    transactions.reference,
                    transactions.`status`,
                    transactions.created_at,
                    transactiondetails.subtotal,
                    currencies.`code`,
                    users.`name` as merchant
                FROM
                    transactions
                INNER JOIN transactiondetails ON transactiondetails.transaction_id = transactions.id
                INNER JOIN currencies ON currencies.id = transactiondetails.currency_id
                INNER JOIN users ON transactions.user_id = users.id
                WHERE
                    transactions.trxndeleted = '0'
                AND transactions.`status` = 'SUCCESSFUL'
                AND transactions.trxnnum = '$trxnnum'
                AND transactions.id NOT IN (
                    SELECT
                        transaction_id
                    FROM
                        refunds
                    WHERE
                        refunddeleted = '0'
                )
            "
        );


        if (empty($transaction)) {
            return response()->json(['error'=> array(
                'Transaction Number: '.$request->trxnnum.' is not refundable.'
            )]);
        }

        return response()->json(['success'=> array(
            'id' => $transaction[0]->id,
            'trxnnum' => $transaction[0]->trxnnum,
            'subtotal' => number_format($transaction[0]->subtotal,2),
            'merchant' => $transaction[0]->merchant,
            'code' => $transaction[0]->code,
            'created_at' => $transaction[0]->created_at,
            'reference' => $transaction[0]->reference,
            'status' => $transaction[0]->status,
        )]);

    }

}
