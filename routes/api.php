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
	Route::get('/',['as' => 'pacients.all', 'uses' => 'PacientsController@getAll']);
	Route::get('/{id}',['as' => 'pacient', 'uses' => 'PacientsController@get']);
	Route::post('/', 'PacientsController@store');
});