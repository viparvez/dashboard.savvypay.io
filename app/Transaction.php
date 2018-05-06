<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'trxnnum', 'clientunique_id', 'user_id','amount','callback_url','gateway_id','trxndeleted','gatewaytrxn_id'
        ];
    

    public function User() {
    	return $this->belongsTo('App\User');
    }

    public function Gateway() {
    	return $this->belongsTo('App\Gateway');
    }

    public function Refund() {
        $this->hasOne('App\Refund', 'transaction_id');
    }

    public function Methodtype() {
        return $this->belongsTo('App\methodtype', 'methodtype_id');
    }
}