<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
	  public function Transaction() {
	  	return $this->belongsTo('App\Transaction', 'transaction_id');
	  }
}
