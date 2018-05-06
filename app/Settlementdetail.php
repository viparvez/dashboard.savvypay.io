<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settlementdetail extends Model
{
    protected $fillable = ['methodtype_id', 'user_id', 'invCode', 'TotalAmount', 'Charge', 'CreditableAmount'];

    public function Methodtype() {
    	return $this->belongsTo('App\methodtype', 'methodtype_id');
    }

    public function User() {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function Settlement() {
    	return $this->belongsTo('App\Settlement', 'invCode');
    }
}
