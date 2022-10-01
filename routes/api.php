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

Route::group(['namespace' => 'App\Http\Controllers\API'], function () {

    Route::apiResource('category', 'Category\CategoryController');
    Route::apiResource('tag', 'Tag\TagController');

    //ٌRoute for filter by (tag & category) and get all ads OR advertiser ads
    Route::get('ads/{advertiser_id?}',"Ads\AdsController@ads");
});