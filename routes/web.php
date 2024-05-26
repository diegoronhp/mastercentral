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

/*************************************************************** */
/*****************DIEGO MAURICIO MANCERA SUAREZ***************** */
/*************************************************************** */


//DEFINICION DE TODAS LAS RUTAS DE NAVEGACION QUE VAN A SER UTLIZADAS POR LA APLICACION DURANTE LA INTERACCION CON EL USUARIO 
Route::get('/','ReservaController@index')->name('home');
Route::get('/reservas','ReservaController@index')->name('reservas');
Route::get('/reservasshowlabs','ReservaController@showlabs')->name('reservas.showlabs');
Route::get('/reservasshowusers','ReservaController@showusers')->name('reservas.showusers');
Route::post('/reservastore','ReservaController@store')->name('reserva.store');
Route::post('/reservaupdate/{id}','ReservaController@update')->name('reserva.update');
Route::post('/reservadelete/{id}','ReservaController@delete')->name('reserva.delete');

