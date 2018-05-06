<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
	protected $fillable = ['invCode', 'GrandTotalAmount', 'user_id', 'TotalChargable', 'TotalCreditable', 'estim_setldate', 'note', 'status'];


    public function User() {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function Settlementdetail() {
    	return $this->hasMany('App\Settlementdetail','invCode');
    }
}
