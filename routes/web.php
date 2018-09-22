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
    $categories = \App\Category::all();
    return view('index')->withCategories($categories);
});

Auth::routes();
Route::get('/home', 'ItemsController@index')->name('home');
//Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/','CategoryController@dashboard');
    Route::resource('categories', 'CategoryController');
    Route::get('/users','UserController@index')->name('user.home');
    Route::delete('/users/{user}','UserController@destroy')->name('user.destroy');
});
// Vendor/Worker Routes
Route::resource('items','ItemsController');
Route::delete('/delImg/{item}','ItemsController@delImage');
Route::post('/items/{item}','ItemsController@update');
Route::get('/getItems','ItemsController@items');
//Cart Operations
Route::get('/addToCart/{item}','CartController@addToCart');
Route::post('/addToCart','CartController@updateCart');
Route::get('/getCart','CartController@getCart');
Route::get('/cart','CartController@index')->name('cart');
Route::post('/cart/save','CartController@save');
Route::post('/updateCart','CartController@updateCart')->name('updateCart');
Route::delete('/delCartItem/{item}','CartController@delCartItem');
Route::delete('/emptyCart','CartController@emptyCart');
//Checkout
Route::get('/checkout','CartController@show');
Route::post('/checkout','CartController@save');
//Orders
Route::get('/orders','OrdersController@index');