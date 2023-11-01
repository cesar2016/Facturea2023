<?php

use App\Http\Controllers\Api\BrandProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\TypeSaleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CurrentAccountController;
use App\Http\Controllers\FinanceController;
use App\Models\BrandProduct;
use Illuminate\Foundation\Bootstrap\RegisterProviders;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// # TESTING ROUTE
Route::get('/test', function(){
     return 'FACTUREA-V1-API';
});

// Ruta para recalcular las deudas
Route::get('recalculating_debt/{identificator_sale}',[PaymentController::class, 'recalculating_debt']);



// # REGISTER
//Route::post('register',[RegisterController::class, 'store']); //OLD
Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::post('showUser',[AuthController::class, 'showUser'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {


// # CATEGORY
Route::get('categories',[CategoryController::class, 'index'])->name('api.v1.categotries.index');
Route::post('categories',[CategoryController::class, 'store'])->name('api.v1.categotries.store');
Route::get('categories/{category}',[CategoryController::class, 'show'])->name('api.v1.categotries.show');
Route::put('categories/{category}',[CategoryController::class, 'update'])->name('api.v1.categotries.update');
Route::delete('categories/{category}',[CategoryController::class, 'destroy'])->name('api.v1.categotries.delete');

// # BRAND PRODUCTS
Route::get('brandProducts',[BrandProductController::class, 'index'])->name('api.v1.brandProducts.index');
Route::post('brandProducts',[BrandProductController::class, 'store'])->name('api.v1.brandProducts.store');
Route::get('brandProducts/{brandProduct}',[BrandProductController::class, 'show'])->name('api.v1.brandProducts.show');
Route::put('brandProducts/{brandProduct}',[BrandProductController::class, 'update'])->name('api.v1.brandProducts.update');
Route::delete('brandProducts/{brandProduct}',[BrandProductController::class, 'destroy'])->name('api.v1.brandProducts.delete');

// # CLIENTS
Route::get('clients',[ClientController::class, 'index'])->name('api.v1.clients.index');
Route::post('clients',[ClientController::class, 'store'])->name('api.v1.clients.store');
Route::get('clients/{client}',[ClientController::class, 'show'])->name('api.v1.clients.show');
Route::put('clients/{client}',[ClientController::class, 'update'])->name('api.v1.clients.update');
Route::delete('clients/{client}',[ClientController::class, 'destroy'])->name('api.v1.clients.delete');

// # PROVIDER
Route::get('providers',[ProviderController::class, 'index'])->name('api.v1.providers.index');
Route::post('providers',[ProviderController::class, 'store'])->name('api.v1.providers.store');
Route::get('providers/{provider}',[ProviderController::class, 'show'])->name('api.v1.providers.show');
Route::put('providers/{provider}',[ProviderController::class, 'update'])->name('api.v1.providers.update');
Route::delete('providers/{provider}',[ProviderController::class, 'destroy'])->name('api.v1.providers.delete');

// - Rutas para aumentos
Route::post('providers_aumento',[ProviderController::class, 'aumento_update'])->name('api.v1.providers.aumento_update');


// # PRODUCTS
Route::get('products',[ProductController::class, 'index'])->name('api.v1.products.index');
Route::post('products',[ProductController::class, 'store'])->name('api.v1.products.store');
Route::get('products/{product}',[ProductController::class, 'show'])->name('api.v1.products.show');
Route::put('products/{product}',[ProductController::class, 'update'])->name('api.v1.products.update');
Route::delete('products/{product}',[ProductController::class, 'destroy'])->name('api.v1.products.delete');

// # SALES
//Route::get('sales',[SaleController::class, 'index'])->name('api.v1.sales.index');
Route::post('sales',[SaleController::class, 'store'])->name('api.v1.sales.store');
Route::get('sales/{sale}',[SaleController::class, 'show'])->name('api.v1.sales.show');
Route::put('sales/{sale}',[SaleController::class, 'update'])->name('api.v1.sales.update');
Route::delete('sales/{sale}',[SaleController::class, 'destroy'])->name('api.v1.sales.delete');
Route::get('show_for_id/{sale}',[SaleController::class, 'show_for_id'])->name('api.v1.sales.show_for_id');


// # PAYMENTS
Route::get('payments',[PaymentController::class, 'index'])->name('api.v1.payments.index');
Route::post('payments',[PaymentController::class, 'store'])->name('api.v1.payments.store');
Route::get('payments/{payment}',[PaymentController::class, 'show'])->name('api.v1.payments.show');
Route::put('payments/{payment}',[PaymentController::class, 'update'])->name('api.v1.payments.update');
Route::delete('payments/{payment}',[PaymentController::class, 'destroy'])->name('api.v1.payments.delete');
Route::delete('destroy_pay/{payments_entrega}',[PaymentController::class, 'destroy_pay'])->name('api.v1.payments.delete_pay');

Route::get('calculator_totals/{payment}',[PaymentController::class, 'calculator_totals'])->name('api.v1.payments.calculator_totals');
Route::post('store_pay_account',[PaymentController::class, 'store_pay_account'])->name('api.v1.store_pay_account.store');
Route::get('last_pay',[PaymentController::class, 'last_pay'])->name('api.v1.payments.last_pay');


// # TYPE SALES
Route::get('typeSales',[TypeSaleController::class, 'index'])->name('api.v1.typeSales.index');
Route::post('typeSales',[TypeSaleController::class, 'store'])->name('api.v1.typeSales.store');
Route::get('typeSales/{type_sale}',[TypeSaleController::class, 'show'])->name('api.v1.typeSales.show');
Route::put('typeSales/{type_sale}',[TypeSaleController::class, 'update'])->name('api.v1.typeSales.update');
Route::delete('typeSales/{type_sale}',[TypeSaleController::class, 'destroy'])->name('api.v1.typeSales.delete');


// # Finanzas
Route::get('daily_cash',[FinanceController::class, 'daily_cash'])->name('api.v1.daily_cash');
Route::post('frame_cash',[FinanceController::class, 'frame_cash'])->name('api.v1.frame_cash');

//Route::get('finances/daily_cash',[FinanceController::class, 'daily_cash']);






});




