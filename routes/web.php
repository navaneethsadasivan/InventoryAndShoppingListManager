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

Route::get('/generate', function () {
   return view('generateShoppingList');
});

Route::get('/list', function () {
    return view('userShoppingList');
});

Route::get('/search', function () {
    return view('search');
});

Route::get('/inventory', function () {
    return view ('userInventory')->with('user', Auth::check());
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
    '/postShoppingList', 'AjaxController@postShoppingList'
)->name('postShoppingList');

Route::get(
    '/getHistory', 'AjaxController@getHistory'
)->name('getHistory');

Route::post(
    '/postNewList', 'AjaxController@postNewList'
)->name('postNewList');

Route::post(
    '/postSearchItem', 'AjaxController@postSearchItem'
)->name('postSearchItem');

Route::post(
    '/postAddItem', 'AjaxController@postAddNewItem'
)->name('postAddItem');

Route::put(
    '/putUpdateItem', 'AjaxController@putUpdateItem'
)->name('putUpdateItem');

Auth::routes();

Route::get(
    '/home', 'HomeController@index'
)->name('home');

Route::get(
    '/getUserInventory', 'AjaxController@getUserInventory'
)->name('getUserInventory');

Route::post(
    '/postAddItemUserInventory', 'AjaxController@postAddItem'
)->name('postAddItemUserInventory');

Route::post(
    '/postRemoveItemUserInventory', 'AjaxController@postRemoveItem'
)->name('postRemoveItemUserInventory');

Route::get(
    '/getPrevBoughtItemUser', 'AjaxController@getPreviousItem'
)->name('getPreviouslyBoughtItemUser');

Route::get(
    '/getExpiringItems', 'AjaxController@getExpiringItems'
)->name('getExpiringItems');
