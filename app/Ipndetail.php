<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ipndetail extends Model
{
    public function APIuser(){
    	$this->belongsTo('App\User','user_id');
    }

    public function Createdby() {
        return $this->belongsTo('App\User','createdbyuser_id');
    }

    public function Updatedby() {
        return $this->belongsTo('App\User','updatedbyuser_id');
    }
    
}
