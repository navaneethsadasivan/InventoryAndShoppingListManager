<?php

use App\Http\Controllers\ShoppingListController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/item', function () {
    return view('item');
});

Route::get('/list', function () {
   return view('shoppingList');
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/search', function () {
    return view('search');
});

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


/*
|--------------------------------------------------------------------------
| Data Routes
|--------------------------------------------------------------------------
|
*/

Route::get(
    '/getItems', 'AjaxController@getInventoryItems'
)->name('getItems');

Route::get(
    '/getList', 'AjaxController@getShoppingList'
)->name('getList');

Route::get(
    '/getApriori', 'AjaxController@getApriori'
)->name('getApriori');

Route::post(
    '/postHistory', 'AjaxController@postHistory'
)->name('postHistory');

Route::post(
    '/postNewList', 'AjaxController@postNewList'
)->name('postNewList');

Route::post(
    '/postSearchItem', 'AjaxController@postSearchItem'
)->name('postSearchItem');

Route::post(
    '/postAddItem', 'AjaxController@postAddNewItem'
)->name('postAddItem');

Auth::routes();

Route::get(
    '/home', 'HomeController@index'
)->name('home');
