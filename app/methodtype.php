<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Methodtype extends Model
{
    protected $fillable = ['name', 'active', 'createdbyuser_id', 'updatedbyuser_id'];

    public function Settlemetrule() {
    	return $this->hasMany('App\settlementrule', 'methodtype_id');
    }

    public function Gateway() {
    	return $this->belongsTo('App\Gateway', 'gateway_id');
    }

    public function Transaction() {
        return $this->hasMany('App\Transaction', 'methodtype_id');
    }

    public function Createdby() {
        return $this->belongsTo('App\User','createdbyuser_id');
    }

    public function Updatedby() {
        return $this->belongsTo('App\User','updatedbyuser_id');
    }
}
