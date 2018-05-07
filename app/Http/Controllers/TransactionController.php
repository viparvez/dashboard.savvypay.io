<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use Auth;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::where(['trxndeleted' => '0'])->orderBy('created_at','DESC')->get();
        return view('layouts.pages.transactions', compact('transactions'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $transaction = Transaction::where(['id' => $id])->first();

        if (!empty($transaction)) {
            $data = "
                <div class='box box-primary' style='font-weight:bold'>
                    <div class='box-body box-profile'>
                        <table class='table table-striped details-view'>
                            <tr>
                                <td>Transaction Number:</td><td>{$transaction->trxnnum}</td>
                            </tr>

                            <tr>
                                <td>Status:</td><td>{$transaction->status}</td>
                            </tr>

                            <tr>
                                <td>Amount:</td><td>".number_format($transaction->Transactiondetail->subtotal,2)." ".$transaction->Transactiondetail->Currency->code."</td>
                            </tr>


                            <tr>
                                <td>Currency:</td><td>{$transaction->Transactiondetail->Currency->name} ({$transaction->Transactiondetail->Currency->code})</td>
                            </tr>

                            <tr>
                                <td>Gateway:</td><td>{$transaction->Transactiondetail->Gateway->name}</td>
                            </tr>

                            <tr>
                                <td>Method:</td><td>{$transaction->Transactiondetail->Methodtype->name}</td>
                            </tr>

                            <tr>
                                <td>Merchant:</td><td>{$transaction->User->name}</td>
                            </tr>

                            <tr>
                                <td>Created Date:</td><td>".$transaction->created_at->format('d/m/Y g:i A')."</td>
                            </tr>

                            <tr>
                                <td>Updated Date:</td><td>".$transaction->updated_at->format('d/m/Y g:i A')."</td>
                            </tr>

                            <tr>
                                <td>Updated By:</td><td>{$transaction->Updatedby->name}</td>
                            </tr>

                            <tr>
                                <td>Shipping:</td><td>".$transaction->Transactiondetail->Currency->code." ".number_format($transaction->Transactiondetail->shipping,2)."</td>
                            </tr>

                            <tr>
                                <td>TAX:</td><td>".$transaction->Transactiondetail->Currency->code." ".number_format($transaction->Transactiondetail->tax,2)."</td>
                            </tr>

                            <tr>
                                <td>VAT:</td><td>".$transaction->Transactiondetail->Currency->code." ".number_format($transaction->Transactiondetail->vat,2)."</td>
                            </tr>

                            <tr>
                                <td>Sub Total:</td><td>".$transaction->Transactiondetail->Currency->code." ".number_format($transaction->Transactiondetail->subtotal,2)."</td>
                            </tr>

                            <tr>
                                <td>Reference:</td><td>{$transaction->reference}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            ";

            return $data;
        }
        
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
}
