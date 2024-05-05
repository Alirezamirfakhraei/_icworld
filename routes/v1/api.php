<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\App\Http\Controllers\v1\CategoriesController;
use Modules\ContactUs\App\Http\Controllers\ContactUsController;
use Modules\Products\App\Http\Controllers\v1\ProductsController;

Route::middleware(['throttle:30,1'])->prefix('v1')->group(function () {
    // ----------> ContactUs
    Route::controller(ContactUsController::class)->group(function () {
        Route::post('message/set', 'setMessage');
    });

    // ----------> Products
    Route::controller(ProductsController::class)->group(function () {
        Route::get('product/{id}', 'getAllProducts');
        Route::post('product/ptn', 'getProductWithPtn');
    });

    // ----------> Categories
    Route::controller(CategoriesController::class)->group(function () {
        Route::post('category', 'getAllCategories');
    });

});




