<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class settlementrule extends Model
{
    protected $fillable = ['name','methodtype_id', 'bill_policy', 'amount', 'deleted'];

    public function Methodtype() {
    	return $this->belongsTo('App\methodtype', 'methodtype_id');
    }

    public function merchantrule() {
    	return $this->belongsToMany('App\merchantrule', 'rule_id');
    }

}
