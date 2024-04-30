<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ContactUs\App\Http\Controllers\ContactUsController;
use Modules\Products\App\Http\Controllers\ManufacturerController;
use Modules\Products\App\Http\Controllers\v1\ProductsController;


require "v1/api.php";

Route::get('/update/count', [ProductsController::class, 'updateCount']);
