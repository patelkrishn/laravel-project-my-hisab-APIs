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

Route::group(['namespace' => 'Api\Admin','prefix'=>'admin'], function () {
    // Route::post('login','AuthController@login');
    // Route::post('register','AuthController@register');
    // Route::post('me','AuthController@me')->middleware('auth:admin');
    // Route::post('logout','AuthController@logout')->middleware('auth:admin');
});

Route::group(['namespace' => 'Api\Seller','prefix'=>'seller'], function () {
    Route::post('login','AuthController@login');
    Route::post('register','AuthController@register');
    Route::post('seller_update','AuthController@update');
    Route::post('me','AuthController@me')->middleware('auth:seller');
    Route::post('logout','AuthController@logout')->middleware('auth:seller');
    Route::apiResource('product','ProductController')->middleware('auth:seller');
    Route::apiResource('shop_address','ShopAddressController')->middleware('auth:seller');
    Route::apiResource('legal_information','LegalInformationController')->middleware('auth:seller');
    Route::apiResource('inventory','InventoryController')->middleware('auth:seller');
    Route::get('inventory/list/{id}','InventoryController@list')->middleware('auth:seller');
    Route::apiResource('user','UserController')->middleware('auth:seller');
    Route::apiResource('invoices','InvoiceController')->middleware('auth:seller');
});

Route::group(['namespace' => 'Api\User','prefix'=>'user'], function () {
    // Route::post('login','AuthController@login');
    // Route::post('register','AuthController@register');
    // Route::post('me','AuthController@me')->middleware('auth:api');
    // Route::post('logout','AuthController@logout')->middleware('auth:api');
});

