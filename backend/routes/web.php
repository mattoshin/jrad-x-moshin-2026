<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\validatesController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Admin;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\DiscordStrategiesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ControlCategoriesController;
use App\Http\Controllers\BackDoorController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PlansController;

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
Route::group(['middleware'=>['api']],function(){

});
Route::group(['middleware' => 'web'], function () {

    Route::view('/', 'landing');    
    Route::get('/@me', [DiscordStrategiesController::class, 'me']);
    Route::get('/dashboard', [UserController::class,'homeRedirect']);
//Discord Login
    Route::get('/user', 'App\Http\Controllers\Api\AuthenticationController@index');
    Route::get('/login', [DiscordStrategiesController::class, 'redirectToProvider'])->name('/login');
    Route::get('/login/handle', [DiscordStrategiesController::class, 'handleProviderCallback']);
    Route::get('/logout', [DiscordStrategiesController::class, 'logout']);
    Route::get('/home', [DiscordStrategiesController::class, 'returnHome']);
    Route::get('/account',[DiscordStrategiesController::class,'account']);
    Route::get('/me',[DiscordStrategiesController::class,'me']);
    Route::get('/guilds',[DiscordStrategiesController::class,'getBusinesses']);
    
    Route::get('/stripe',[StripeController::class,'stripe'])->name('stripe');
    Route::get('/stripe-checkout',[StripeController::class,'subscriptionCheckout'])->name('stripeCheckout');
    Route::get('/stripe-success',[StripeController::class,'stripeSuccess']);
    Route::get('/thank-you',[StripeController::class,'thankYou']);
    Route::post('/stripe-payment',[StripeController::class,'subscriptionCreate']);
    Route::post('/webhook_stripe',[SubscriptionsController::class,'webhookResponse']);
    
    Route::get('/admin', [BackDoorController::class, 'getAdmin'])->name('login')->middleware('isAdmin:true');
    Route::get('/admin/logs', [LogsController::class, 'getAll']);

    Route::get('/admin/log/{id}', [LogsController::class, 'getById']);
    Route::post('/adminlog', [BackDoorController::class, 'postLogin'])->name('login.post');
    Route::get('/admin/logout', [BackDoorController::class, 'logout'])->name('logout'); 
    //Route::get('/admin/signs',[BackDoorController::class,'adminSign']);
   // Route::post('/admin/sign',[BackDoorController::class, 'signUp']);
    Route::middleware(['prefix'=>'admin','middleware'=> 'adminauth'])->group(function () { });
  
    Route::get('/admin/home', [StripeController::class, 'dashboard'])->middleware('isAdmin:true');
    Route::get('admin/users', [UserController::class, 'adminIndex'])->middleware('isAdmin:true');
    Route::get('admin/user/{id}',[UserController::class, 'getId'])->middleware('isAdmin:true');
Route::post('admin/user/{userId}/toggleAdmin',[UserController::class, 'toggleAdmin'])->middleware('isAdmin:true');
    Route::get('admin/businesses', [BusinessController::class, 'index'])->middleware('isAdmin:true');
    Route::get('admin/business/{id}',[BusinessController::class, 'getId'])->middleware('isAdmin:true');
    Route::get('/admin/invoices', [OrdersController::class, 'GetAll']);
    Route::get('/admin/invoice/{id}', [OrdersController::class, 'grabById']);
    Route::get('admin/plan/{id}',[PlansController::class, 'getById'])->middleware('isAdmin:true');
    Route::post('admin/plan/{id}/update',[PlansController::class, 'adminUpdate'])->middleware('isAdmin:true');

    Route::get('admin/plan/{id}/delete',[PlansController::class, 'deleteById'])->middleware('isAdmin:true');
    
    Route::get("/admin/coupons", function(){
        return View::make("coupons");
     });
     Route::get("/admin/coupon/1", function(){
        return View::make("coupon");
    });
    Route::get("/admin/create-coupon", function(){
        return View::make("create-coupon");
     });
    
    Route::get('/admin/add-product', [BackDoorController::class, 'addProduct'])->middleware('isAdmin:true');
    Route::post('/admin/save-product', [StripeController::class, 'stripeProduct']);
    Route::get('admin/product/edit/{id}', [ProductsController::class, 'getId'])->middleware('isAdmin:true');
    Route::post('admin/product/edit/{id}', [ProductsController::class, 'updateProduct'])->middleware('isAdmin:true');
    Route::post('admin/product/category/update', [ControlCategoriesController::class, 'adminUpdate'])->middleware('isAdmin:true');
    Route::post('admin/product/category/create', [ControlCategoriesController::class, 'adminCreate'])->middleware('isAdmin:true');
    Route::get('admin/products', [ProductsController::class, 'adminIndex'])->middleware('isAdmin:true');
    Route::get('admin/product/delete/{id}', [StripeController::class, 'deleteProduct'])->middleware('isAdmin:true')->name('deleteProduct');

    Route::get('admin/category/add', [ProductsController::class, 'productCategoryView'])->middleware('isAdmin:true')->name('addCategory');
    Route::get('admin/categories', [ProductsController::class, 'productCategory'])->middleware('isAdmin:true')->name('manageCategory');
    Route::post('admin/save-category', [ProductsController::class, 'saveProductCategory'])->middleware('isAdmin:true');
    Route::get('admin/category/edit/{id}', [ProductsController::class, 'editCategory_view'])->middleware('isAdmin:true')->name('editCategory_view');
    Route::post('admin/category/update/{id}', [ProductsController::class, 'editCategory_save'])->middleware('isAdmin:true')->name('editCategory_save');
    Route::get('admin/productSS', [ProductsController::class, 'viewAddProduct'])->middleware('isAdmin:true')->name('viewAddProduct');
    Route::post('admin/directMessage/{id}', [UserController::class, 'directMessage'])->middleware('isAdmin:true')->name('directMessage');
});


Route::put('/updateUser',[UserController::class, 'update']);


Route::view('/select', 'select');
