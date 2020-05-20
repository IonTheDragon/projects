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
    return view('welcome');
});

Auth::routes();

Route::get('/authors', 'HomeController@authors');
Route::get('/books', 'HomeController@books');
Route::get('/search', 'HomeController@search');
Route::any('/get_authors', 'HomeController@get_authors');
Route::any('/get_books', 'HomeController@get_books');
Route::any('/search_books', 'HomeController@search_books');

Route::group(['middleware' => ['auth']], function() {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/add_author_form', 'HomeController@add_author_form');
	Route::any('/add_author', 'HomeController@add_author');	
	Route::get('/add_book_form', 'HomeController@add_book_form');
	Route::any('/add_book', 'HomeController@add_book');	
});
