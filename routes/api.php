<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// AUTH
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


//API route for register new user
Route::post('/register', [AuthController::class, 'register']);
//API route for login user
Route::post('/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // CUSTOMERS API
    Route::apiResource('customers', CustomerController::class);
    Route::get('/customers/search/{keyword}',[CustomerController::class, 'search'])->name('customer.search');

    // CARTS API
    Route::apiResource('carts', CartController::class);
    Route::get('/carts/by_customer/{customerId}', [CartController::class, 'getByCustomer'])->name('carts.byCustomer');
    Route::get('/cart/{id}/cart_items',[CartItemController::class, 'byCart'])->name('cart_items.byCart');

    // CART ITEMS API
    Route::apiResource('cart_items', CartItemController::class);
    Route::post('/cart_items/{id}/get_invoice_item',[CartItemController::class, 'get_invoice_item'])->name('cart_items.getInvoiceItem');

    // INVOICES API
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('/invoices/make_invoice',[InvoiceController::class, 'make_invoice'])->name('invoice.make_invoice');

    // INVOICE ITEMS API
    Route::apiResource('invoice_items', InvoiceItemController::class);

    // PRODUCTS API
    Route::apiResource('products', ProductController::class);

    // DISCOUNTS API
    Route::apiResource('discounts', DiscountController::class);

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/user', [AuthController::class, 'user']);
});