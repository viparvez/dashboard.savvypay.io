<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchantdocument extends Model
{

	protected $fillable = ['fileType', 'file'];
	
	public function Createdby() {
		return $this->belongsTo('App\User','createdbyuser_id');
	}

	public function Updatedby() {
		return $this->belongsTo('App\User','updatedbyuser_id');
	}
}
