<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', 'MainController@index');
Route::post('/', 'MainController@checkDiscount');

foreach (['service' => 'ServiceController', 'discount' => 'DiscountController'] as $prefix => $controller) {
    Route::group(['prefix' => $prefix], function () use ($controller) {
        Route::get('', $controller . '@index');
        Route::get('add', $controller . '@add');
        Route::get('edit/{id}', $controller . '@edit');
        Route::post('save', $controller . '@store');
        Route::get('delete/{id}', $controller . '@delete');
    });
}
