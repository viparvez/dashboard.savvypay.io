<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify/{verifyToken}', 'UserController@verifyUser')->name('verifyUser');

Auth::routes();

Route::get('/', array('as' => 'landing', 'uses' => 'PagesController@getLogin'));
Route::get('/login', array('as' => 'login', 'uses' => 'PagesController@getLogin'));
Route::get('/register', array('as' => 'register', 'uses' => 'PagesController@getRegister'));

Route::group(['middleware' => 'auth'], function(){

	Route::get('/home', 'PagesController@index')->name('view-home');

	Route::get('/settlements', 'PagesController@setlView')->name('setlView');
	Route::post('/settle', 'SettlementController@settle')->name('settle');

	Route::get('/requestarefund', 'PagesController@refReq')->name('refReqView');
	Route::POST('/request-refund', 'RefundController@refReq')->name('refReq');
	Route::POST('/postrefreq', 'RefundController@postrefreq')->name('postrefreq');

	Route::get('/methodtype', 'PagesController@methodtype')->name('methodtype');
	Route::post('/methodtype', 'SettingsController@SaveMethodtype')->name('saveMethodtype');

	Route::post('/settlementrules', 'SettingsController@saveSettlementrules')->name('saveSettlementrules');
	Route::post('/settlementrulesupdate', 'SettingsController@UpdateSettlementrules')->name('updateSettlementrules');

	Route::post('/merchantruleUpdate', 'SettingsController@updateMerchantrule')->name('updateMerchantrule');


	Route::post('/createSettlement', 'SettingsController@createSettlement')->name('createSettlement');

	Route::get('/invoice/{id}', 'PagesController@showInvoice')->name('showInvoice');
	Route::get('/downLoadPDF/{id}', 'PagesController@downLoadPDF')->name('downLoadPDF');



	Route::get('/test/{user_id}/{methodtype_id}', 'PagesController@MerchantRuleForUser')->name('test');


	Route::resources([
	    'transactions' => 'TransactionController',
	    'gateways' => 'GatewayController',
	    'methodtypes' => 'MethodtypeController',
	    'users' => 'UserController',
	    'refunds' => 'RefundController',
	    'settlementrules' => 'SettlementruleController',
	    'merchantrules' => 'MerchantrulesController',
	    'self-registration' => 'SelfRegController',
	    'documents' => 'DocumentController',
	    'ipn' => 'IpnController',
	]);


	Route::post('/refunds/search', 'RefundController@search')->name('refunds.search');
	Route::post('/users/api/search/', 'UserController@apiUserList')->name('users.apisearch');

});