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

Route::group(
    [
        'prefix' => 'addon/bing_submit_url',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\BingSubmitUrl\Controllers'
    ], function () {
    Route::get('/', 'SubmitController@index')->name('addon.bing_submit_url.index');
    Route::get('/config', 'SubmitController@config')->name('addon.bing_submit_url.config');
    Route::post('/config', 'SubmitController@store');
    Route::get('/create', 'SubmitController@create')->name('addon.bing_submit_url.create');
    Route::post('/create', 'SubmitController@push');
});
