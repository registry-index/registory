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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    //view関連
    Route::get('/', 'PropertyController@index')->name('property.index');
    Route::get('property/{id}', 'PropertyController@show')->name('property.show');
    //file関連
    Route::get('/file/form', 'FileController@form')->name('file.form');
    Route::post('/file/upload', 'FileController@upload')->name('file.upload');
});
