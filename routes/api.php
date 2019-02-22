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

Route::resource('Aspirante', 'AspiranteController');
Route::resource('Carrera_Universidad', 'Carrera_UniversidadController');
Route::resource('Dependencia', 'DependenciaController');

Route::resource('Aspirante', 'AspiranteController');
Route::resource('Carrera_Universidad', 'Carrera_UniversidadController');
Route::resource('Dependencia', 'DependenciaController');

Route::resource('CAT_INCAPACIDAD', 'CatincapacidadController');
Route::resource('CAT_PROPAGANDA_TECNOLOGICO', 'CatpropagandaController');

Route::resource('CreditosSiia','CreditosSiiaController');
