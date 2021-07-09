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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'homeController@index')->name('home');

Route::post('/apiBasedLogin', 'apiAuthenticationsController@loginAttempt');
Route::get('/apiBasedLogOut', 'apiAuthenticationsController@logOutAttempt');


Route::group(array('middleware' => ['authAndAcl']), function() {

    Route::get('/item/add-item', 'ItemController@index');
    Route::get('/item/image-crop', 'ItemController@imgCrop');
    Route::get('/item/item-list', 'ItemController@itemList');
    Route::post('/item/get-list', 'ItemController@getList');
    Route::post('/item/add-new-item', 'ItemController@store');
    Route::post('/item/get-item-info', 'ItemController@itemInfo');
    Route::post('/item/view-item-info', 'ItemController@itemInfoView');
    Route::post('/item/delete-item', 'ItemController@deleteItem');
    Route::post('/item/update-item', 'ItemController@updateItem');

    Route::get('/category/category-list', 'categoryController@categoryList');
    Route::post('/category/get-list', 'categoryController@getList');
    Route::post('/category/add-new-category', 'categoryController@store');
    Route::post('/category/get-category-info', 'categoryController@categoryInfo');
    Route::post('/category/delete-category', 'categoryController@deleteCategory');
    Route::post('/category/update-category', 'categoryController@updateCategory');

    Route::get('/brand/brand-list', 'brandController@brandList');
    Route::post('/brand/get-list', 'brandController@getList');
    Route::post('/brand/add-new-brand', 'brandController@store');
    Route::post('/brand/get-brand-info', 'brandController@brandInfo');
    Route::post('/brand/delete-brand', 'brandController@deleteBrand');
    Route::post('/brand/update-brand', 'brandController@updateBrand');

    Route::get('/shop/shop-list', 'shopController@shopList');
    Route::post('/shop/get-list', 'shopController@getList');
    Route::post('/shop/add-new-shop', 'shopController@store');
    Route::post('/shop/get-shop-info', 'shopController@shopInfo');
    Route::post('/shop/delete-shop', 'shopController@deleteShop');
    Route::post('/shop/update-shop', 'shopController@updateShop');

    Route::get('/product-var-type/list', 'pvtController@pvtList');
    Route::post('/product-var-type/get-list', 'pvtController@getList');
    Route::post('/product-var-type/add-new-pvt', 'pvtController@store');
    Route::post('/product-var-type/get-pvt-info', 'pvtController@pvtInfo');
    Route::post('/product-var-type/delete-pvt', 'pvtController@deletePVT');
    Route::post('/product-var-type/update-pvt', 'pvtController@updatePVT');

    Route::get('/admin-user/list', 'adminUserController@userList');
    Route::post('/admin-user/get-list', 'adminUserController@getList');
    Route::post('/admin-user/add-new-user', 'adminUserController@store');
    Route::post('/admin-user/get-user-info', 'adminUserController@adminInfo');
    Route::post('/admin-user/delete-user', 'adminUserController@deleteAdmin');
    Route::post('/admin-user/update-user', 'adminUserController@updateAdmin');

    Route::get('/city/list', 'cityController@cityList');
    Route::post('/city/get-list', 'cityController@getList');
    Route::post('/city/add-new-city', 'cityController@store');
    Route::post('/city/get-city-info', 'cityController@cityInfo');
    Route::post('/city/delete-city', 'cityController@deleteCity');
    Route::post('/city/update-city', 'cityController@updateCity');

    Route::get('/location/list', 'locationController@locationList');
    Route::post('/location/get-list', 'locationController@getList');
    Route::post('/location/add-new-location', 'locationController@store');
    Route::post('/location/get-location-info', 'locationController@locationInfo');
    Route::post('/location/delete-location', 'locationController@deleteLocation');
    Route::post('/location/update-location', 'locationController@updateLocation');

    Route::get('/order/list', 'manageOrderController@index');
    Route::post('/order/get-pending-order-list', 'manageOrderController@getPendingList');
    Route::post('/order/get-confirmed-list', 'manageOrderController@confirmedContent');
    Route::post('/order/get-picked_for_delivery-list', 'manageOrderController@pickedForDeliveryContent');
    Route::post('/order/get-delivered-list', 'manageOrderController@deliveredContent');
    Route::post('/order/get-canceled-list', 'manageOrderController@canceledContent');
    Route::post('/order/get-order-details', 'manageOrderController@orderDetails');
    Route::post('/order/update-status', 'manageOrderController@updateStatus');


    Route::get('/coupon/list', 'couponController@couponList');
    Route::post('/coupon/get-list', 'couponController@getList');
    Route::post('/coupon/add-new-coupon', 'couponController@store');
    Route::post('/coupon/get-coupon-info', 'couponController@couponInfo');
    Route::post('/coupon/delete-coupon', 'couponController@deleteCoupon');
    Route::post('/coupon/update-coupon', 'couponController@updateCoupon');

    Route::get('/user/profile', 'usersController@index');
    Route::post('/dashboard/gate-content', 'homeController@dashboardContent');

    Route::get('/order/invoice/{order_id}', 'invoiceController@index');

});

