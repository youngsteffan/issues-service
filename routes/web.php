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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/requests', 'TicketsController@userTickets')->name('user.tickets');
Route::get('/request/create', 'TicketsController@create')->name('request.create');
Route::post('/request/create', 'TicketsController@store');
Route::get('/request/{ticket_id}', 'TicketsController@show');
Route::get('/search', 'TicketsController@search')->name('search');


Route::post('comment', 'CommentsController@postComment');


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('requests', 'TicketsController@index')->name('requests.all');
    Route::post('request/close/{ticket_id}', 'TicketsController@close')->name('request.close');
    Route::post('request/reopen/{ticket_id}', 'TicketsController@reOpen')->name('request.reopen');
    Route::post('request/assign/{ticket_id}', 'TicketsController@assign')->name('request.assign');
    Route::get('requests/assigned', 'TicketsController@assignedTickets')->name('requests.assigned');
});

