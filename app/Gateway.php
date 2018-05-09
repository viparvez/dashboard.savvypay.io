<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
	protected $fillable = ['name','active'];
    
	public function Transaction() {
		return $this->hasMany('App\Transaction', 'gateway_id');
	}

	public function Methodtype() {
		return $this->hasMany('App\methodtype', 'gateway_id');
	}

	public function Createdby() {
		return $this->belongsTo('App\User','createdbyuser_id');
	}

	public function Updatedby() {
		return $this->belongsTo('App\User','updatedbyuser_id');
	}

}
