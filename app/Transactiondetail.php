<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactiondetail extends Model
{

	public function Gateway() {
		return $this->belongsTo('App\Gateway');
	}
    
    public function Methodtype() {
        return $this->belongsTo('App\methodtype', 'methodtype_id');
    }

    public function Currency() {
    	return $this->belongsTo('App\Currency', 'currency_id');
    }

}
