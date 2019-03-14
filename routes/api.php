<?php

use Illuminate\Http\Request;

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('sendPasswordResetLink','ResetPasswordController@sendEmail');
    Route::post('resetPassword','ChangePasswordController@process');
});

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

Route::resource('Aspirante', 'AspiranteController');
Route::resource('Carrera_Universidad', 'Carrera_UniversidadController');
Route::resource('Dependencia', 'DependenciaController');

Route::resource('Aspirante', 'AspiranteController');
Route::resource('Carrera_Universidad', 'Carrera_UniversidadController');
Route::resource('Dependencia', 'DependenciaController');

Route::resource('CAT_INCAPACIDAD', 'CatincapacidadController');
Route::resource('CAT_PROPAGANDA_TECNOLOGICO', 'CatpropagandaController');

Route::resource('CreditosSiia','CreditosSiiaController');
