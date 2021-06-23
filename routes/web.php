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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get','post'],'index','ImageController@index');
Route::match(['get','post'],'upload-image','ImageController@uploadimage');
Route::match(['get','post'],'delete-image/{id}','ImageController@delete');
Route::match(['get','post'],'delete-singal-image/{imagename}','ImageController@deleteimage');
Route::match(['get','post'],'singal-image/','ImageController@singalimage');