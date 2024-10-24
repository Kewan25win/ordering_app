<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;

Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);

use App\Http\Controllers\CategoryController;


use App\Http\Controllers\BrandController;

Route::get('/brands', [BrandController::class, 'index']); // Get all brands
Route::get('/brands/{id}', [BrandController::class, 'show']); // Get a single brand
//Route::post('/brands', [BrandController::class, 'store']); // Create a new brand
//Route::put('/brands/{id}', [BrandController::class, 'update']); // Update an existing brand
//Route::delete('/brands/{id}', [BrandController::class, 'destroy']); // Delete a brand


Route::get('/categories', [CategoryController::class, 'index']); // Get all categories
Route::get('/categories/{id}', [CategoryController::class, 'show']); // Get a single category
//Route::post('/categories', [CategoryController::class, 'store']); // Create a new category
//Route::put('/categories/{id}', [CategoryController::class, 'update']); // Update a category
//Route::delete('/categories/{id}', [CategoryController::class, 'destroy']); // Delete a category
Route::get('categories/brand/{brand_id}/categories', [CategoryController::class, 'getByBrandId']);


use App\Http\Controllers\SubcategoryController;

Route::get('/subcategories', [SubcategoryController::class, 'index']);
Route::get('/subcategories/{id}', [SubcategoryController::class, 'show']);
//Route::post('/subcategories', [SubcategoryController::class, 'store']);
//Route::put('/subcategories/{id}', [SubcategoryController::class, 'update']);
//Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy']);

// Custom route to get subcategories by category_id
Route::get('/subcategories/category/{category_id}', [SubcategoryController::class, 'getByCategoryId']);



use App\Http\Controllers\ItemController;

Route::get('items', [ItemController::class, 'index']);
//Route::post('items', [ItemController::class, 'store']);
Route::get('items/{id}', [ItemController::class, 'show']);
//Route::put('items/{id}', [ItemController::class, 'update']);
//Route::delete('items/{id}', [ItemController::class, 'destroy']);
Route::get('items/subcategory/{subcategory_id}', [ItemController::class, 'getItemsBySubcategory']);
Route::get('/items/search', [ItemController::class, 'searchByName']);


use App\Http\Controllers\CartController;

Route::get('carts', [CartController::class, 'index']);
Route::post('carts', [CartController::class, 'store']);
Route::get('carts/{id}', [CartController::class, 'show']);
Route::delete('carts/{id}', [CartController::class, 'destroy']);
Route::delete('carts/{id}/clear', [CartController::class, 'clearCart']);


use App\Http\Controllers\CartItemController;

Route::post('cart-items', [CartItemController::class, 'store']);
Route::put('cart-items/{id}', [CartItemController::class, 'update']);
Route::delete('cart-items/{id}', [CartItemController::class, 'destroy']);

Route::get('/carts/user/{user_id}/items', [CartController::class, 'getCartItemsByUser']);
Route::get('/carts/user/{user_id}/items', [CartController::class, 'getCartItemsByUser']);




use App\Http\Controllers\OrderController;

// Order Routes
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Order Item Routes
Route::post('/orders/{orderId}/items', [OrderController::class, 'storeItems']);


Route::post('/carts/{cart_id}/create-order', [OrderController::class, 'createOrderFromCart']);





