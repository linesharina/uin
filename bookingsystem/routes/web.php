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
    return view('booking.create-step1');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/booking-dato', 'BookingController@create1')->name('booking.create-step1');
Route::get('/booking-rom', 'BookingController@show2')->name('booking.show-step2');
Route::get('/booking-fasiliteter', 'BookingController@show3')->name('booking.show-step3');
Route::get('/booking-registrer', 'BookingController@show4')->name('booking.show-step4');
Route::get('/booking-sammendrag', 'BookingController@show5')->name('booking.show-step5');
Route::get('/booking-takk', 'BookingController@show6')->name('booking.show-step6');
Route::post('/booking-rom', 'BookingController@create2')->name('booking.create-step2');
Route::post('/booking-fasiliteter', 'BookingController@create3')->name('booking.create-step3');
Route::post('/booking-registrer', 'BookingController@create4')->name('booking.create-step4');
Route::post('/booking-sammendrag', 'BookingController@create5')->name('booking.create-step5');
Route::post('/booking-takk', 'BookingController@create6')->name('booking.create-step6');



Route::post('/booking-login', 'BookingController@login')->name('booking.login');
