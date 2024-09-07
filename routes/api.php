<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;


Route::group([
    'middleware' => 'api'
], function ($router) {
    // Route::post('/register', [AuthController::class, 'register']);
    
});

Route::apiResource('products',ProductController::class)->middleware('throttle:productLimit2');



