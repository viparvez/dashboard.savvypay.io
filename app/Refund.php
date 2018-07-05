<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{

	protected $fillable = ['transaction_id', 'createdbyuser_id', 'updatedbyuser_id', 'status', 'refundeleted','refundnote'];

	  public function Transaction() {
	  	return $this->belongsTo('App\Transaction', 'transaction_id');
	  }
}
