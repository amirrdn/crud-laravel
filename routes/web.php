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

Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/books', 'BooksController@index')->name('booksindex');
Route::get('/get-books', 'BooksController@GetBooks')->name('ajaxbook');
Route::get('/create-books', 'BooksController@create')->name('create');
Route::post('/insert-books', 'BooksController@store')->name('storebooks');
Route::get('/edit-books/{id}', 'BooksController@edit')->name('editbooks');
Route::post('/update-books/{id}', 'BooksController@update')->name('updatebooks');
Route::get('/delete-books/{id}', 'BooksController@destroy')->name('deletebooks');
Route::post('/delete-checked-books', 'BooksController@destroyarray')->name('deletearraybooks');

Route::get('/borrowing-books-list', 'TransactionController@index')->name('transaction');
Route::get('/borrowing-books', 'TransactionController@transactions')->name('transactionForm');
Route::get('/borrowing-books/datatable', 'TransactionController@ajaxTrasn')->name('ajaxTrasn');
Route::get('/borrowing-books-ajax/{id}', 'TransactionController@ajaxBoox')->name('ajaxtransactionForm');
Route::post('/borrowing-books-insert', 'TransactionController@store')->name('inserttransactionsection');
Route::post('/borrowing-books-update/status', 'TransactionController@updateStatus')->name('updateStatus');
Route::get('/borrowing-books-update/edit/{id}', 'TransactionController@edit')->name('edittrans');
Route::post('/borrowing-books/update/{id}', 'TransactionController@update')->name('updatetrans');
Route::get('/borrowing-books/delete/{id}', 'TransactionController@destroy')->name('destroytrans');
Route::post('/borrowing-books/delete-array', 'TransactionController@destroyarray')->name('destroytransarray');

Route::get('/users', 'UserController@index')->name('usersindex');
Route::get('/users-ajax', 'UserController@ajaxUser')->name('ajaxUser');
Route::get('/users-create', 'UserController@create')->name('userscreate');
Route::post('/users-store', 'UserController@store')->name('userstore');
Route::get('/users-edit/{id}', 'UserController@edit')->name('editusers');
Route::post('/users-update/{id}', 'UserController@update')->name('updateusers');
Route::get('/users-delete/{id}', 'UserController@destroy')->name('destroyusers');
Route::get('/users-delete/array', 'UserController@destroyarray')->name('destroyarrayusers');
