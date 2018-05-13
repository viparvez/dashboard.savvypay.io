<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'trxnnum', 'hash', 's_key', 'user_id','reference','status','trxndeleted',
        ];
    

    public function User() {
    	return $this->belongsTo('App\User','user_id');
    }

    public function Refund() {
        $this->hasOne('App\Refund', 'transaction_id');
    }

    public function Transactiondetail() {
        return $this->hasOne('App\Transactiondetail','transaction_id');
    }

    public function Createdby() {
        return $this->belongsTo('App\User','createdbyuser_id');
    }

    public function Updatedby() {
        return $this->belongsTo('App\User','updatedbyuser_id');
    }
}