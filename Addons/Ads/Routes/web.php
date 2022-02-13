<?php

Route::group(
    [
        'prefix' => 'addon/ads',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Ads\Controllers'
    ], function () {
    Route::get('/', 'AdsController@index')->name('addon.ads.index');
    Route::get('/review', 'AdsController@review')->name('addon.ads.review');
    Route::get('/edit', 'AdsController@edit')->name('addon.ads.edit');
    Route::post('/edit', 'AdsController@update');
    Route::get('/create', 'AdsController@create')->name('addon.ads.create');
    Route::post('/create', 'AdsController@store');
    Route::post('/destroy', 'AdsController@destroy');
    Route::get('/config', 'AdsController@config')->name('addon.ads.config');
    Route::post('/config', 'AdsController@storeCfg');
});

Route::group(['namespace' => 'Addons\Ads\Controllers'], function () {
    Route::get('/ad/{code}/jump', 'AdResourceController@jump')->name('addon.ads.jump');
});
