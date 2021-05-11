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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/item/add-item', 'ItemController@index');
Route::get('/item/item-list', 'ItemController@itemList');
Route::post('/item/get-list', 'ItemController@getList');
Route::post('/item/add-new-item', 'ItemController@store');
Route::post('/item/get-item-info', 'ItemController@itemInfo');
Route::post('/item/delete-item', 'ItemController@deleteItem');

Route::get('/category/category-list', 'CategoryController@categoryList');
Route::post('/category/get-list', 'CategoryController@getList');
Route::post('/category/add-new-category', 'CategoryController@store');
Route::post('/category/get-category-info', 'CategoryController@categoryInfo');
Route::post('/category/delete-category', 'CategoryController@deleteCategory');

Route::get('/brand/brand-list', 'BrandController@brandList');
Route::post('/brand/get-list', 'BrandController@getList');
Route::post('/brand/add-new-brand', 'BrandController@store');
Route::post('/brand/get-brand-info', 'BrandController@brandInfo');
Route::post('/brand/delete-brand', 'BrandController@deleteBrand');

Route::get('/shop/shop-list', 'ShopController@shopList');
Route::post('/shop/get-list', 'ShopController@getList');
Route::post('/shop/add-new-shop', 'ShopController@store');
Route::post('/shop/get-shop-info', 'ShopController@shopInfo');
Route::post('/shop/delete-shop', 'ShopController@deleteShop');
