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
use App\Http\Controllers\Api\FirebaseAuthController;
use App\Http\Controllers\AuthController;


Route::apiResource('addons', AddonController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order_items', OrderItemController::class);
Route::apiResource('discounts', DiscountController::class);
Route::apiResource('loyalty_points', LoyaltyPointController::class);
Route::apiResource('users', UserController::class);
Route::post('/auth/firebase', [FirebaseAuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class,'login']);


    
    // Ruta para obtener los datos del usuario autenticado (Opcional, pero útil)
