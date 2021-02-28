<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/inventory', 'Web\InventoryController@index');

Route::get('/inventory/create', 'Web\InventoryController@create');

Route::post('/inventory/store', 'Web\InventoryController@store');

Route::get('/inventory/{id}', 'Web\InventoryController@show');

Route::post('/inventory/update/{id}', 'Web\InventoryController@update');
