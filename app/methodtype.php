<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Methodtype extends Model
{
    protected $fillable = ['name','gateway_id'];

    public function Settlemetrule() {
    	return $this->hasMany('App\settlementrule', 'methodtype_id');
    }

    public function Gateway() {
    	return $this->belongsTo('App\Gateway', 'gateway_id');
    }

    public function Transaction() {
        return $this->hasMany('App\Transaction', 'methodtype_id');
    }
}
