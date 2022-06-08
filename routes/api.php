<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::namespace('App\Http\Controllers\Api')->group(function(){
    //menampilkan semua data atau 1 data 
Route::get('users/{id?}', 'UserController@getUsers');
//menambah data
Route::post('add-users','UserController@addUser');

Route::post('add-multiple-users','UserController@addMultipleUsers');
});
Route::post('add-produk','App\Http\Controllers\Api\ProdukController@addProduk');
Route::get('product/{id?}','App\Http\Controllers\Api\ProdukController@getProduct');
Route::get('koli/common/{id?}','App\Http\Controllers\Api\KoliController@getKoli');
Route::post('add-koli','App\Http\Controllers\Api\KoliController@addKoli');
Route::put('update-koli/{id}','App\Http\Controllers\Api\KoliController@updateKoli');
