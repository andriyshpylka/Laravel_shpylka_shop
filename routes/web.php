<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(array(
    'reset'=>false,
    'confirm'=>false,
    'verify'=>false,
    )
);
Route::get('locale/{locale}', 'MainController@changeLocale')->name('locale');
Route::middleware(['set_locale'])->group(function() {


    Route::post('subscription/{product}', 'MainController@subscribe')->name('subscription');

    Route::get('/logout', 'Auth\LoginController@logout')->name('get-logout');


    Route::middleware(['auth'])->group(function() {

        Route::group(['prefix'=>'person','namespace'=>'Person','as'=>'person.'],function(){

            Route::get('/orders', 'OrderController@index')->name('orders.index');
            Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
        });

        Route::group(['namespace'=>'Admin','prefix'=>'admin',], function(){
            Route::group(['middleware'=>'is_admin'],function(){
                Route::get('/orders', 'OrderController@index')->name('home1');
                Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');

                Route::resource('categories','CategoryController');
                Route::resource('products','ProductController');
            });

        });
    });




    Route::group(['prefix'=>'basket'],function() {
        Route::post('/add/{id}','BasketController@basketAdd')->name('basket-add');
        Route::group(['middleware' => 'basket_not_empty'], function () {
            Route::get('/', 'BasketController@basket')->name('basket');
            Route::post('/remove/{id}', 'BasketController@basketRemove')->name('basket-remove');
            Route::get('/place', 'BasketController@basketPlace')->name('basket-place');
            Route::post('/confirm', 'BasketController@basketConfirm')->name('basket-confirm');
        });
    });



    Route::get('/', 'MainController@index')->name('index');

    Route::get('/categories', 'MainController@categories')->name('categories');


    Route::get ('/{category}', 'MainController@category')->name('category');



    Route::get('/{category}/{product}','MainController@product')->name('product');

});






















Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
