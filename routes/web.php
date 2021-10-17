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

Route::get('/admin/registerl', function () {
    return view('site.register');
});

Route::get('/1', [SiteEventController::class, 'index']);
Route::get('/event/register/{registerid}', 'SiteEventController@registerevent')->name('register'); // Сторінка яка показує зареєстрованих учасників 

// Route::get('/event', 'SiteEventController@index')->name('home');
Route::get('/event/{id}', 'SiteEventController@show')->name('homes');
Route::get('/admin/register/add', 'AdminRegisterController@getAdd')->name('homes');
Route::get('/admin/register/edit/{id}', 'AdminRegisterController@getAdd')->name('homes');
Route::get('/event', ['uses' => 'SiteEventController@index', 'as' => 'event']);


Route::get('/autocomplete', 'TestController@autocomplete')->name('homes');
Route::get('/autocomplete2', 'TestController@autocomplete2')->name('homes');
Route::get('/autocomplete3', 'TestController@autocomplete3')->name('homes');
Route::post('/admin/registers', 'AdminCmsRegisterUsers@add')->name('homes');
// Route::get('/autocomplete2', 'TestController@index')->name('homes');/


Route::get('/online', 'SiteOnlineController@indexonline')->name('online');
Route::get('/online/rezult/{id}', 'SiteOnlineController@showrezult')->name('rezult');
Route::get('/online/startlist/{id}', 'SiteOnlineController@showstartlist')->name('startlist');
Route::get('/online/split/{id}', 'SiteOnlineController@showsplit')->name('split');
Route::get('/online/showpeople/{name}', 'SiteOnlineController@showpeople')->name('showpeople');
