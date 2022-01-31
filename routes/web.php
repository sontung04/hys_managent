<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();

Route::middleware('auth')->group(function (){
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('/user')->group(function () {
        Route::get('/list', 'UserController@list')->name('user.list');
        Route::get('/create', 'UserController@create')->name('user.create');
        Route::get('/profile/{id?}', 'UserController@profile')->name('user.profile')->where('id', '[0-9]+');
        Route::post('/saveInfo', 'UserController@saveInfo');
    });

    Route::prefix('/group')->group(function () {
        Route::get('/list', 'GroupController@list')->name('group.list');
        Route::get('/detail/{id}', 'GroupController@detail')->where('id', '[0-9]+')->name('group.detail');
        Route::post('/saveInfo', 'GroupController@saveInfo');
    });

    Route::prefix('/event')->group(function () {
        Route::get('/list', function () {
            return view('events.list');})->name('event.list');
    });

});

