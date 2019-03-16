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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('calender','CalenderController@index')->name('calender.index');
Route::group(['prefix'=>'admin', 'middleware' => 'auth'], function() {
	Route::get('role','RoleController@index')->name('role.index');
	Route::put('role/{user}','RoleController@update')->name('role.update');
	Route::resource('location','LocationController');
	Route::resource('equipment','EquipmentController');
	Route::group(['prefix'=>'equipment/{equipment}', 'middleware' => 'auth'], function() {
		Route::resource('service','ServiceController');
	});
	Route::get('system','SystemController@index')->name('system.index');
	Route::group(['prefix'=>'system/{system}', 'middleware' => 'auth'], function() {
		Route::get('/','SystemController@setting')->name('system.setting');
		Route::post('application/{application}','SystemController@transferapplicationbooking')->name('system.transferapplicationbooking');
		Route::post('block/{module}','BlockController@store')->name('system.blockingslot');
	});	
});
/*
|--------------------------------------------------------------------------
| Routes For API
|--------------------------------------------------------------------------
|
| No description
|
*/

Route::group(['prefix'=>'api'], function() {
	Route::get('getequipmentservices/{equipment}','ServiceController@api_getequipmentservices')->name('getequipmentservices');
	Route::get('getavailableslotbyservice/{service}','ApiController@getavailableslotbyservice')->name('getavailableslotbyservice');
	Route::get('getavailableslotbyapplication/{application}','ApiController@getavailableslotbyapplication')->name('getavailableslotbyapplication');
	Route::get('getserviceprice/{service}','ServiceController@api_getserviceprice')->name('getserviceprice');
	
	Route::get('testapi','ApiController@testapi')->name('testapi');
	Route::get('mailable', function () {
	    $supervisor = \App\Supervisor::find(1);

	    return new App\Mail\NotifySupervisor($supervisor);
	});

});

/*
|--------------------------------------------------------------------------
| Routes For Student
|--------------------------------------------------------------------------
|
| No description
|
*/
	
// student accesible api
Route::group(['prefix'=>'/', 'middleware' => 'auth'], function() {

	Route::resource('application','ApplicationController')->except([
				    'store'
				]);
	Route::get('booking/regslot/{booking}','BookingController@regslot')->name('booking.regslot');
	Route::resource('booking','BookingController');
	Route::get('bookingupdatebyemail/{booking}','BookingController@updatebyemail')->name('booking.updatebyemail');
	Route::group(['prefix'=>'booking/{booking}', 'middleware' => 'auth'], function() {
		Route::resource('sample','SampleController');
		Route::resource('application','ApplicationController')->only([
				    'store'
				]);
	});
});


