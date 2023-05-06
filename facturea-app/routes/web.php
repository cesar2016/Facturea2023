<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Brand_categoryController;
use App\Http\Controllers\Client_acountController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Proforma_C_Controller;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReciveController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::post('/registerUser',[UserController::class, 'registerUser'])->name('registerUser');
Route::get('/registerUser', function () {
    return view('auth.login');
})->name('registerUser');
Route::post('/loginUser',[UserController::class, 'loginUser'])->name('loginUser');

Route::get('/showUser',[UserController::class, 'showUser'])->name('showUser')->middleware('token_Auth');
Route::get('/logout',[UserController::class, 'destroy'])->name('logout')->middleware('token_Auth');

Route::get('/env_js',[HomeController::class, 'env_js'])->name('env_js');



Auth::routes();


Route::group(['middleware' => 'token_Auth'], function () {

Route::get('/testing',[UserController::class, 'testing']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/clients', [ClienteController::class, 'index'])->name('clients');
Route::get('/providers', [ProviderController::class, 'index'])->name('providers');
Route::get('/brand_categorys', [Brand_categoryController::class, 'index'])->name('brand_categorys');


Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/sale', [SaleController::class, 'index'])->name('sale');
Route::post('/recive', [ReciveController::class, 'store'])->name('recive');
Route::GET('/create_invoice_c', [Proforma_C_Controller::class, 'create_invoice_c'])->name('create_invoice_c');

Route::get('/client_acount/{id}', [Client_acountController::class, 'index'])->name('client_acount');










});

