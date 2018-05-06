<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function transaction() {
        return $this->hasMany('App\Transaction', 'user_id');
    }

    public function address() {
        return $this->hasOne('App\Address', 'user_id');
    }

    public function Settlement() {
        return $this->hasMany('App\Settlement', 'user_id');
    }

    public function Merchantrule() {
        return $this->hasMany('App\merchantrule', 'user_id')->where(['deleted' => '0']);
    }
}
