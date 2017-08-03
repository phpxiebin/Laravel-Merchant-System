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

//系统自带(作为前台, 目前暂维持原样)
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


//商户管理平台
Route::group(['namespace' => 'Merchant', 'prefix' => 'merchant'], function () {
    //todo 无需授权
    Route::group(['prefix' => 'auth'], function () {
        //登录页面
        Route::get('/login', 'AuthController@authenticate');
        //授权登录(触发内置用户认证)
        Route::post('/login', 'AuthController@login');
        //用户注册
        Route::get('/register', 'AuthController@register');
        //检测是否登录
        Route::get('/check', 'AuthController@check');
        //用户退出
        Route::get('/logout', 'AuthController@logout');
    });

    //todo 需授权分组
    Route::group(['middleware' => ['auth:merchant']], function () {

        //控制台主页
        Route::get('/', 'HomeController@index')->name('home');

        //人脸数据管理
        Route::group(['prefix' => 'face'], function () {
            //列表页
            Route::get('/', 'FaceController@index')->name('face');
            //增加人脸
            Route::match(['get', 'post'], '/store', 'FaceController@store')->name('face.store');
            //修改人脸
            Route::match(['get', 'post'], '/update', 'FaceController@update')->name('face.update');
            //删除人脸
            Route::match(['get', 'post'], '/destroy', 'FaceController@destroy');
        });

        //组数据管理
        Route::group(['prefix' => 'group'], function () {
            //列表页
            Route::get('/', 'GroupController@index')->name('group');
            //增加组
            Route::match(['get', 'post'], '/store', 'GroupController@store')->name('group.store');
            //修改组
            Route::match(['get', 'post'], '/update', 'GroupController@update')->name('group.update');
            //组识别
            Route::match(['get', 'post'], '/identify', 'GroupController@identify')->name('group.identify');
            //删除组
            Route::match(['get', 'post'], '/destroy', 'GroupController@destroy');
        });
    });
});