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


// Route::get('/pacients', 'PacientsController@getAllPacients');

Route::prefix('pacient')->group(function () {
	Route::get('/',['as' => 'pacient.all', 'uses' => 'PacientsController@getAll']);
	Route::get('/{id}',['as' => 'pacient', 'uses' => 'PacientsController@get']);
	Route::post('/',['as' => 'pacient.store', 'uses' => 'PacientsController@store']);
});

Route::prefix('doctor')->group(function () {
	Route::get('/',['as' => 'doctor.all', 'uses' => 'DoctorsController@getAll']);
	Route::get('/{id}',['as' => 'doctor', 'uses' => 'DoctorsController@get']);
	Route::post('/',['as' => 'doctor.store', 'uses' => 'DoctorsController@store']);
});

Route::prefix('appointment')->group(function () {
	Route::get('/',['as' => 'appointment.all', 'uses' => 'AppointmentsController@getAll']);
	Route::get('/{id}',['as' => 'appointment', 'uses' => 'AppointmentsController@get']);
	Route::get('/{init}/{fin}',['as' => 'appointment.range', 'uses' => 'AppointmentsController@getByRange']);
	Route::post('/',['as' => 'appointment.store', 'uses' => 'AppointmentsController@store']);
});