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
    return view('home');
});


Route::post('/simulate', 'SimulationController@simulate');

Route::get('Kunden/create', 'KundeController@create_api');

Route::get('Produkte/create', 'ProduktController@create_api');

Route::get('Stores/create', 'StoreController@create_api');

Route::get('Mitarbeiter/create', 'MitarbeiterController@create_api');

Route::get('Transaktionen/create', 'TransaktionController@create_api');

Route::get('/test', 'TestController@test');

Route::get('/truncate', 'TestController@truncate');

Route::get('/results/show', 'SimulationController@results');

Route::get('/results/{name}', 'SimulationController@result');

Route::get('/dwh-operations', 'SimulationController@dwh_operations');

Route::get('/Mitarbeiter/{Mitarbeiter}/products_sold', 'MitarbeiterController@products_sold');

Route::get('/Produkte/{Produkt}/total_sales', 'ProduktController@total_sales');

Route::post('/results/delete', 'SimulationController@delete');