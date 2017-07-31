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

//route zur Eingabemaske
Route::get('/', 'HomeController@home');

//zeige DWH-Operationen an
Route::get('/imprint', 'HomeController@imprint');

//zeige DWH-Operationen an
Route::get('/privacy', 'HomeController@privacy');

//Simulationsfunktion
Route::post('/simulate', 'SimulationController@simulate');

//Zeige ergebnisse an
Route::get('/results/show', 'ResultController@results');

//lösche ergebnisse
Route::post('/results/delete', 'ResultController@delete');

//zeige DWH-Operationen an
Route::get('/dwh-operations', 'DWHController@home');

//führe DWH-Operation aus
Route::post('/Mitarbeiter/products_sold', 'DWHController@products_sold');

//führe DWH-Operation aus
Route::post('Produkte/total_sales', 'DWHController@total_sales');

