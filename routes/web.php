<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/', 'FrontController@front')->name('front')/*->middleware('admin')*/;


Route::post('/add_img', 'ImageController@add')->name('add.img')->middleware('auth');
Route::get('/del_session', 'ImageController@delSession')->name('del.session')->middleware('auth');
Route::any('/upload_img/id{id}', 'ImageController@uploadDrop')->name('upload.img')->middleware('auth');
Route::any('/delete_img', 'ImageController@deleteDrop')->name('delete.img')->middleware('auth');

Route::get('/id{id}', 'ObjectController@view')->name('object.view');
Route::match(['get', 'post'],'/add_obj', 'ObjectController@add')->name('object.add')->middleware('auth');
Route::match(['get', 'post'],'/edit_obj/id{id}', 'ObjectController@edit')->name('object.edit')->middleware('auth');
Route::get('/delete_obj/id{id}', 'ObjectController@delete')->name('object.delete')->middleware('auth');
Route::get('/update_location', 'ObjectController@updateLocation')->name('update.location');

Route::get('/messages', 'MessageController@myMessages')->name('my.messages')->middleware('auth');
Route::get('/message{id}', 'MessageController@view')->name('view.messages')->middleware('auth');
Route::post('/add_message', 'MessageController@add')->name('add.message')->middleware('auth');
Route::get('/delete_message', 'MessageController@deleteMsg')->name('delete.message')->middleware('auth');
Route::post('/check_message', 'MessageController@checkNewMsg')->name('check.message')->middleware('auth');
Route::post('/notified', 'MessageController@notified')->name('notified.message')->middleware('auth');


Route::any('/autocomplete', 'SearchController@autocomplete')->name('autocomplete');
Route::any('/test', 'SearchController@test')->name('test');
Route::post('/get_city', 'SearchController@getCityId')->name('get.city');

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";
})->name('clear');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



