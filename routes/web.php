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

Route::get('/', function () {
    return view('index');
})->name('index');

Auth::routes();

Route::middleware('auth')->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::prefix('/user')->group(function () {
        Route::get('/profile/{id?}', 'UserController@profile')->name('user.profile')->where('id', '[0-9]+');
        Route::get('/edit/{id?}', 'UserController@edit')->name('user.edit')->where('id', '[0-9]+');
        Route::post('/saveInfo', 'UserController@saveInfo');
    });

});

