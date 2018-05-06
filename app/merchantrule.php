<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class merchantrule extends Model
{
    protected $fillable = ['user_id','rule_id','deleted'];

    public function User() {
    	return $this->belongsTo('App\User','user_id');
    }

    public function Settlementrule() {
    	return $this->belongsTo('App\settlementrule','rule_id');
    }
}
