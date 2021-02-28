<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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



//Register User
Route::post('/register', 'API\AuthController@register');

//Login User
Route::post('/login', 'API\AuthController@login');

//Transactions
Route::middleware('auth:api')->get('/inventory', 'API\InventoryController@index');

Route::middleware('auth:api')->post('/inventory/store', 'API\InventoryController@store');

Route::middleware('auth:api')->get('/inventory/{id}', 'API\InventoryController@show');

Route::middleware('auth:api')->post('/inventory/update/{id}', 'API\InventoryController@update');
