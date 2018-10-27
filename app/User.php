<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'api_user', 'password','active', 'deleted', 'createdbyuser_id', 'updatedbyuser_id'
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

    public function Address() {
        return $this->hasOne('App\Address', 'user_id');
    }

    public function Settlement() {
        return $this->hasMany('App\Settlement', 'user_id');
    }

    public function Merchantrule() {
        return $this->hasMany('App\merchantrule', 'user_id')->where(['deleted' => '0']);
    }

    public function Merchant() {
        return $this->belongsTo('App\User', 'merchant_user_id');
    }

    //Get list of API users associated with a merchant account
    public function Merchantuserapi($merchant_user_id) {
        return DB::SELECT(
            "
                SELECT
                    mer.`name` AS merchant,
                    mer.email AS merchant_email,
                    mer.id AS merchant_user_id,
                    api.username AS api_user,
                    api.id AS api_user_id,
                    ipn.web_service_url AS ipn_url,
                    ipn.phone AS ipn_phone,
                    ipn.email AS ipn_email,
                    ipn.`comment` AS ipn_comment
                FROM
                    merchantapirelations rel
                INNER JOIN users mer ON mer.id = rel.merchant_user_id
                INNER JOIN users api ON api.id = rel.api_user_id
                LEFT JOIN ipndetails ipn ON ipn.api_user_id = rel.api_user_id
                WHERE
                    mer.id = '$merchant_user_id'
            "
        );
    }

    //Get list of API Merchant users against an api user
    /*public function Apiusermerchant($api_user) {
        return DB::SELECT(
            "
                SELECT api_user_id, merchant_user_id FROM merchantapirelations
                WHERE api_user_id = '$api_user'
            "
        );
    }*/


    public function Createdby() {
        return $this->belongsTo('App\User','createdbyuser_id');
    }

    public function Updatedby() {
        return $this->belongsTo('App\User','updatedbyuser_id');
    }

    public function Ipn() {
        return $this->hasOne('App\Ipndetail', 'user_id');
    }

}
