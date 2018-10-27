<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchantapirelation extends Model
{
	public function Merchantuser() {
        return $this->belongsToMany('App\Merchantapirelation','merchant_user_id');
    }

    public function Merchantapiuser() {
        return $this->belongsToMany('App\User','api_user_id');
    }
    
    public function Apiusermerchant() {
        return $this->hasMany('App\User','merchant_user_id');
    }

    public function Createdby() {
        return $this->belongsTo('App\User','createdbyuser_id');
    }

    public function Updatedby() {
        return $this->belongsTo('App\User','updatedbyuser_id');
    }
}
