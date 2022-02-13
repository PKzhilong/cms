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
        'prefix' => 'addon/dede',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Dedecms\Controllers'
    ], function () {

    Route::get('/', 'DedeController@index')->name('addon.dedecms.index');
    Route::get('config', 'DedeController@config')->name('addon.dedecms.config');
    Route::post('config', 'DedeController@storeCfg');
    Route::any('/import/article', 'DedeImportController@article');
    Route::any('/import/goods', 'DedeImportController@goods');
});
