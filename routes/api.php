<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\LoyaltyPointController;
use App\Http\Controllers\UserController;
Route::apiResource('addons', AddonController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order_items', OrderItemController::class);
Route::apiResource('discounts', DiscountController::class);
Route::apiResource('loyalty_points', LoyaltyPointController::class);
Route::apiResource('users', UserController::class);