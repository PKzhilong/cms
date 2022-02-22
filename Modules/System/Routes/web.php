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

Route::group(['prefix' => 'system', 'namespace' => '\Modules\System\Http\Controllers\Admin'], function () {
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('index', 'SystemController@index')->name('system.index');
        Route::get('dashboard', 'SystemController@dashboard')->name('system.dashboard');
        Route::post('upload', 'SystemController@images')->name('system.upload.images');

        Route::get('config', 'ConfigController@index')->name('system.config');
        Route::post('config', 'ConfigController@store');

        Route::get('admin', 'AdminController@index')->name('system.admin');
        Route::post('admin/modify', 'AdminController@modify');
        Route::get('admin/create', 'AdminController@create')->name('system.admin.create');
        Route::post('admin/create', 'AdminController@store');
        Route::get('admin/edit', 'AdminController@edit')->name('system.admin.edit');
        Route::post('admin/edit', 'AdminController@update');
        Route::get('admin/password', 'AdminController@password')->name('system.admin.password');
        Route::post('admin/password', 'AdminController@setPwd');
        Route::post('admin/destroy', 'AdminController@destroy');


        Route::get('role', 'RoleController@index')->name('system.role');
        Route::get('role/create', 'RoleController@create')->name('system.role.create');
        Route::post('role/create', 'RoleController@store');
        Route::get('role/edit', 'RoleController@edit')->name('system.role.edit');
        Route::post('role/edit', 'RoleController@update');
        Route::post('role/destroy', 'RoleController@destroy');
        Route::get('role/auth', 'RoleController@showAuth')->name('system.role.auth');
        Route::post('role/auth', 'RoleController@auth');


        Route::get('menu', 'MenuController@index')->name('system.menu');
        Route::get('menu/create', 'MenuController@create')->name('system.menu.create');
        Route::post('menu/create', 'MenuController@store');
        Route::get('menu/edit', 'MenuController@edit')->name('system.menu.edit');
        Route::post('menu/edit', 'MenuController@update');
        Route::post('menu/destroy', 'MenuController@destroy');
        Route::get('menu/config', 'MenuController@config')->name('system.menu.config');
        Route::post('menu/config', 'MenuController@storeCfg');

        Route::get('addon', 'AddonController@index')->name('system.addon');
        Route::any('addon/install', 'AddonController@install');
        Route::any('addon/uninstall', 'AddonController@uninstall');
        Route::any('addon/init', 'AddonController@init');
        Route::post('addon/modify', 'AddonController@modify');

        Route::get('update-cache', 'SystemController@updateCache');

        Route::get('/attr', 'AttrController@index')->name('system.attr');
        Route::get('/attr/create', 'AttrController@create')->name('system.attr.create');
        Route::post('/attr/create', 'AttrController@store');
        Route::get('/attr/edit', 'AttrController@edit')->name('system.attr.edit');
        Route::post('/attr/edit', 'AttrController@update');
        Route::post('/attr/destroy', 'AttrController@destroy');


        Route::get('/diy-page', 'DiyPageController@index')->name('system.diy-page');
        Route::get('/diy-page/create', 'DiyPageController@create')->name('system.diy-page.create');
        Route::post('/diy-page/create', 'DiyPageController@store');
        Route::get('/diy-page/edit', 'DiyPageController@edit')->name('system.diy-page.edit');
        Route::post('/diy-page/edit', 'DiyPageController@update');
        Route::post('/diy-page/destroy', 'DiyPageController@destroy');
    });

    Route::get('login', 'LoginController@showLoginForm')->name('system.login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout');

});
