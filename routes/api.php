<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


#Route::middleware('auth:api')->get('/get-request', function (Request $request) {
Route::get('/get-request', function (Request $request) {

	$params['code'] 	= 200;
	$params['message'] 	= 'success'; 

	return $params;
});


Route::post('/post-request', function (Request $request) {

	$params['code'] 	= 200;
	$params['message'] 	= 'success'; 
	$params['data'] 	= $request;


	$store 					= new App\Models\AbsensiRequest();
	$store->value  			= $request->input();
	$store->save();

	$absen  				= new App\Models\AbsensiItem();
	$absen->absensi_id 		= $request->absensi_id;

	$user 					= \App\User::where('employee_number', $request->emp_no)->first();
	if($user)
	{
		$absen->user_id 		= $user->id;
	}

	$absen->date 			= $request->date;
	$absen->timetable 		= $request->timetable;
	$absen->on_dutty 		= $request->on_dutty;
	$absen->off_dutty 		= $request->off_dutty;
	$absen->clock_in 		= $request->clock_in;
	$absen->clock_out 		= $request->clock_out;
	$absen->work_time 		= $request->work_time;
	$absen->save();

	return $params;
});
