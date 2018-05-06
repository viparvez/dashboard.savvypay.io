<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

	protected $fillable = [
        'line1', 'line2', 'po','pocode','city','area','country','deleted','user_id','logo_url'
    ];

    public function User() {
    	return $this->belongsTo('App\User');
    }
}
