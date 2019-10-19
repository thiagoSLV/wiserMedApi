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


Route::prefix('/auth')->group(function () {
	Route::post('/pacient', ['as' => 'pacient.authenticate', 'uses' => 'Auth\LoginController@pacientLogin']);
	Route::post('/doctor', ['as' => 'doctor.authenticate', 'uses' => 'Auth\LoginController@doctorLogin']);
});

Route::prefix('pacient')->group(function () {
	Route::get('/',['as' => 'pacient.all', 'uses' => 'PacientsController@getAll']);
	Route::get('/{id}',['as' => 'pacient', 'uses' => 'PacientsController@get']);
	Route::post('/',['as' => 'pacient.store', 'uses' => 'PacientsController@store']);
});

Route::prefix('doctor')->group(function () {
	Route::get('/',['as' => 'doctor.all', 'uses' => 'DoctorsController@getAll']);
	Route::get('/{id}',['as' => 'doctor', 'uses' => 'DoctorsController@get']);
	Route::get('/specialty/{specialty}',['as' => 'doctor.specialty', 'uses' => 'DoctorsController@getBySpecialty']);
	Route::post('/',['as' => 'doctor.store', 'uses' => 'DoctorsController@store']);
});

Route::prefix('appointment')->group(function () {
	Route::get('/',['as' => 'appointment.all', 'uses' => 'AppointmentsController@getAll']);
	Route::get('/{id}',['as' => 'appointment', 'uses' => 'AppointmentsController@get']);
	Route::get('/pacient/{id}',['as' => 'appointment.pacient', 'uses' => 'AppointmentsController@getPacientAppointments']);
	Route::get('/doctor/{id}',['as' => 'appointment.doctor', 'uses' => 'AppointmentsController@getDoctorAppointments']);
	Route::get('/pacient/{id}/{init}/{fin}',['as' => 'appointment.pacient.date.range', 'uses' => 'AppointmentsController@getPacientAppointmentsByDateRange']);
	Route::get('/doctor/{id}/{init}/{fin}',['as' => 'appointment.doctor.date.range', 'uses' => 'AppointmentsController@getDoctorAppointmentsByDateRange']);
	Route::get('/{init}/{fin}',['as' => 'appointment.date.range', 'uses' => 'AppointmentsController@getByDateRange']);
	Route::post('/',['as' => 'appointment.store', 'uses' => 'AppointmentsController@store']);
});