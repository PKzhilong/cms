<?php

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

Route::prefix('v1')->name('api.v1.')
    ->group(function () {

        Route::middleware(['api.sign', 'auth:web'])->group(function () {

            Route::post('/categories', 'CmsController@categories');
            Route::post('/category/info', 'CmsController@categoryInfo');

            Route::post('/articles', 'CmsController@articles2');
            Route::post('/article/info', 'CmsController@articleInfo2');

            Route::post('/store/categories', 'StoreController@categories');
            Route::post('/store/category/info', 'StoreController@categoryInfo');

            Route::post('/store/goods/list', 'StoreController@goodsList');
            Route::post('/store/goods/info', 'StoreController@goodsInfo');

            Route::post('/comments', 'CmsController@comments');
            Route::post('/comment/submit', 'CmsController@submitComment');


            Route::post('/user/info', 'UserController@info');
            Route::post('/user/ranks', 'UserController@ranks');

            Route::post('/system/attrs', 'SystemController@attrs');


        });

        Route::post('/user/login', 'UserController@login');
        Route::post('/user/reg', 'UserController@reg');

        Route::post('/timestamp', 'SystemController@timestamp');
        Route::post('/region', 'SystemController@region');

    });


