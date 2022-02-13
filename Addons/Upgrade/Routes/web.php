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
        'prefix' => 'addon/upgrade',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Upgrade\Controllers'
    ], function () {

    Route::get('/', 'UpgradeController@index')->name('addon.upgrade.index');
    Route::get('/version', 'UpgradeController@version')->name('addon.upgrade.version');
    Route::post('/version', 'UpgradeController@update');

});
