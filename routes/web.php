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

Route::get('/', 'HomeController@home');

Route::post('/simulate', 'SimulationController@simulate');

Route::get('Kunden/create', 'KundeController@create_api');

Route::get('Produkte/create', 'ProduktController@create_api');

Route::get('Stores/create', 'StoreController@create_api');

Route::get('Mitarbeiter/create', 'MitarbeiterController@create_api');

Route::get('Transaktionen/create', 'TransaktionController@create_api');

Route::get('/test', 'TestController@test');

Route::get('/truncate', 'TestController@truncate');

Route::get('/results/show', 'ResultController@results');

Route::post('/results/delete', 'ResultController@delete');

Route::get('/dwh-operations', 'DWHController@home');

Route::post('/Mitarbeiter/products_sold', 'DWHController@products_sold');

Route::post('Produkte/total_sales', 'DWHController@total_sales');