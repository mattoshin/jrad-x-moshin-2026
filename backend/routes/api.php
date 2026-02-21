<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\UserController;
use App\Http\Controllers\DiscordController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ServersController;
use App\Http\Controllers\WebhooksController;
use App\Http\Controllers\ControlCategoriesController;
use App\Http\Controllers\ClientCategoriesController;
use App\Http\Controllers\ClientChannelsController;
use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiscordStrategiesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;


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

Route::middleware('auth:sanctum')->get('/', function (Request $request) {
    return $request->user();
});


//Subscriptions
Route::get('adminSubs', 'App\Http\Controllers\SubscriptionsController@index');
Route::get('adminSubs/{subscription}', 'App\Http\Controllers\SubscriptionsController@show');
Route::post('adminSubs', 'App\Http\Controllers\SubscriptionsController@store');
Route::put('adminSubs/{subscription}', 'App\Http\Controllers\SubscriptionsController@update');
Route::delete('adminSubs/{subscription}', 'App\Http\Controllers\SubscriptionsController@delete');
//Servers
Route::get('servers', 'App\Http\Controllers\ServersController@index');
Route::get('servers/{server}', 'App\Http\Controllers\ServersController@show');
Route::get('server/{id}', 'App\Http\Controllers\ServersController@getId');
Route::get('serverBusiness/{id}','App\Http\Controllers\ServersController@getBusiness');
Route::get('owner/{id}','App\Http\Controllers\ServersController@getOwner');
Route::get('guildid/{id}','App\Http\Controllers\ServersController@getGuildId');
Route::post('servers', 'App\Http\Controllers\ServersController@store');
Route::put('servers/{server}', 'App\Http\Controllers\ServersController@update');
Route::delete('servers/{server}', 'App\Http\Controllers\ServersController@delete');
//Products

Route::group([
    'prefix'=>'products'
], function(){
    Route::get('/', 'App\Http\Controllers\ProductsController@index');
    Route::get('/{product}', [App\Http\Controllers\ProductsController::class, 'getById']);
});


//Invoices

Route::group([
    'prefix' => 'invoices'
], function () {
    Route::post('/{order}/refund', [App\Http\Controllers\StripeController::class, 'refundOrder']);
});
//Route::post('products', 'App\Http\Controllers\ProductsController@store');
Route::put('products/{product}', 'App\Http\Controllers\ProductsController@update');
Route::delete('products/{product}', 'App\Http\Controllers\ProductsController@delete');
//Plans
// Route::get('plans', [App\Http\Controllers\PlansController::class ,'index']);
Route::get('plans/{plan}', [App\Http\Controllers\PlansController::class ,'show']);
Route::get('plan/{id}', [App\Http\Controllers\PlansController::class, 'getId']);
Route::post('plans', [App\Http\Controllers\PlansController::class, 'store']);
Route::put('plans/{plan}', [App\Http\Controllers\PlansController::class, 'update']);
Route::delete('plans/{plan}', [App\Http\Controllers\PlansController::class,'delete']);
//Webhooks
// Route::get('webhooks', 'App\Http\Controllers\WebhooksController@index');
Route::get('webhooks/{webhook}', 'App\Http\Controllers\WebhooksController@show');
Route::post('webhooks', [App\Http\Controllers\WebhooksController::class,'store']);
Route::get('webhook/{channel_id}', [App\Http\Controllers\WebhooksController::class,'getByChannel']);
Route::get('webhooks/{plan}', [App\Http\Controllers\WebhooksController::class,'getByPlan']);
Route::post('mwebhooks',[App\Http\Controllers\WebhooksController::class,'storeWebhooks']);
Route::put('webhooks/{webhook}', 'App\Http\Controllers\WebhooksController@update');
Route::delete('webhooks/{webhook}', 'App\Http\Controllers\WebhooksController@delete');
//Business

Route::group([
    'prefix'=>'businesses'
], function(){
    Route::get('/{business}', 'App\Http\Controllers\BusinessController@show');
    Route::post('/{business}/users', 'App\Http\Controllers\BusinessController@addAdmins');
    Route::delete('/{business}/users', 'App\Http\Controllers\BusinessController@deletePermission');
    Route::post('/', 'App\Http\Controllers\BusinessController@store');
    Route::post('/create', 'App\Http\Controllers\BusinessController@create');
    Route::put('/{business}', 'App\Http\Controllers\BusinessController@update');
    Route::delete('/{business}', 'App\Http\Controllers\BusinessController@delete');
});

Route::group([
    'prefix'=>'business'
], function(){
    Route::get('/@me', 'App\Http\Controllers\BusinessController@getBusinessMe');
    Route::get('/{id}', 'App\Http\Controllers\BusinessController@getId');
    Route::get('/@me/products', 'App\Http\Controllers\BusinessController@getProducts');
    Route::get('/@me/products/active', 'App\Http\Controllers\BusinessController@getActiveProducts');
    Route::get('/@me/products/{product}/announcements', 'App\Http\Controllers\BusinessController@getProductAnnouncements');
    Route::get('/@me/announcements', 'App\Http\Controllers\BusinessController@getAllAnnouncements');
    Route::get('/@me/products/{product}/checkout', 'App\Http\Controllers\StripeController@subscriptionCheckout');
    Route::get('/@me/create_portal', 'App\Http\Controllers\StripeController@createPortalLink');
    Route::post('/@me/products/{product}/cancel', 'App\Http\Controllers\StripeController@subscriptionCancel');
    Route::get('/@me/invoices', 'App\Http\Controllers\BusinessController@getInvoices');
    Route::get('/@me/invoices/{invoice}', 'App\Http\Controllers\BusinessController@getInvoice');
    Route::get('/@me/monitors', 'App\Http\Controllers\BusinessController@getMonitors');
    Route::get('/@me/monitors/{monitor}', 'App\Http\Controllers\BusinessController@getMonitor');
    Route::get('/@me/monitors/{monitor}/webhooks', 'App\Http\Controllers\BusinessController@getMonitorWebhooks');
    Route::post('/@me/monitors/{monitor}/webhooks', 'App\Http\Controllers\WebhooksController@updateMonitorWebhooks');
    Route::get('/@me/plans/{plan}', 'App\Http\Controllers\BusinessController@getPlan');
    Route::put('/@me/plans/{plan}', 'App\Http\Controllers\BusinessController@updatePlan');
    Route::post('/@me/settings', 'App\Http\Controllers\BusinessController@updateBusinessSettings');
});
// Route::get('businesses', 'App\Http\Controllers\BusinessController@index');
// Route::get('owner/{id}','App\Http\Controllers\BusinessController@getOwner');

//Announcements
Route::get('announcements', [AnnouncementsController::class, 'index']);
Route::get('announcements/{announcement}', 'App\Http\Controllers\AnnouncementsController@show');
//Route::post('product/{announcement}', [AnnouncementsController::class, 'store']);
Route::post('announcement', [AnnouncementsController::class, 'store'])->name('announcement');
Route::get('announcementsBy/{id}',[AnnouncementsController::class,'getByProduct']);
Route::post('product', [ProductsController::class, 'store'])->name('product');
Route::post('announcements', [App\Http\Controllers\AnnouncementsController::class,'store']);
Route::put('announcements/{announcement}', 'App\Http\Controllers\AnnouncementsController@update');
Route::delete('announcemen/{id}', [App\Http\Controllers\AnnouncementsController::class,'delete'])->name('delete');


Route::group([
    'prefix'=>'users'
], function(){
    Route::get('/', 'App\Http\Controllers\UserController@index');
    Route::get('/user/{token}', 'App\Http\Controllers\UserController@getByToken');
});

Route::group([
    'prefix'=>'user'
], function(){
    Route::post('/login', 'App\Http\Controllers\DiscordStrategiesController@loginUser');
    Route::get('/{id}','App\Http\Controllers\UserController@userEdit');
    Route::post('/{user}/message', 'App\Http\Controllers\DiscordStrategiesController@messageUser');
    Route::get('/{username}','App\Http\Controllers\UserController@getUsername');
});


Route::group([
    'prefix'=>'bot'
], function(){
    Route::get('servers', 'App\Http\Controllers\ServersController@getServers');
    Route::get('servers/{product}', 'App\Http\Controllers\ServersController@getServersByPlan');
    Route::get('categories/client/{category}', 'App\Http\Controllers\ClientCategoriesController@getByCategory');
    Route::get('categories/control/{category}', 'App\Http\Controllers\ControlCategoriesController@getCategory');
    Route::post('categories/client', 'App\Http\Controllers\ClientCategoriesController@createCategory');
    Route::get('categories/control/{category}/channels', 'App\Http\Controllers\ControlCategoriesController@getCategoryChannels');
    Route::get('channels/control/{channel}', 'App\Http\Controllers\ChannelsController@getChannel');
    Route::get('channels/control/{channel}/channels', 'App\Http\Controllers\ChannelsController@getChannels');
    Route::post('channels/control', 'App\Http\Controllers\ChannelsController@addChannel');
    Route::post('channels/client', 'App\Http\Controllers\ClientChannelsController@addClientChannels');
    Route::put('channels/control', 'App\Http\Controllers\ChannelsController@updateChannel');
    Route::delete('channels/control', 'App\Http\Controllers\ChannelsController@deleteChannel');
});

// Route::post('users', 'App\Http\Controllers\UserController@store');
// Route::put('users/{user}', 'App\Http\Controllers\UserController@update');
// Route::get('usersEmail/{email}', 'App\Http\Controllers\UserController@getEmail');
//Channels
Route::get('channels', 'App\Http\Controllers\ChannelsController@index');
Route::post('channels', 'App\Http\Controllers\ChannelsController@store');
Route::put('channels/{chanel_id}', 'App\Http\Controllers\ChannelsController@update');
Route::get('channels/{id}', 'App\Http\Controllers\ChannelsController@getId');
Route::delete('channels/{channel_id}', 'App\Http\Controllers\ChannelsController@delete');

// Control Categories
Route::post('controlCategories/{control_category}', 'App\Http\Controllers\ControlCategoriesController@input');
Route::get('ControlCategories', 'App\Http\Controllers\ControlCategoriesController@getAll');
Route::get('ControlCategories/{id}', 'App\Http\Controllers\ControlCategoriesController@getById');
Route::put('controlCategorie/{id}','App\Http\Controllers\ControlCategoriesController@update');
Route::get('ControlChannels','App\Http\Controllers\ControlCategoriesController@grabAllChannels');

// client channels
Route::get('clientChannels','App\Http\Controllers\ClientChannelsController@getAll');
Route::get('ClientChannels/{id}', 'App\Http\Controllers\ClientChannelsController@getAllByChannelId');
Route::get('ClientChannel/{id}', 'App\Http\Controllers\ClientChannelsController@getById');
Route::put('clientChannels/{id}','App\Http\Controllers\ClientChannelsController@update');
Route::delete('clientChannels/{id}', 'App\Http\Controllers\ClientChannelsController@delete');

Route::group([
    'prefix'=>'fulfillment'
], function(){
    // Route::get('/{id}', 'App\Http\Controllers\BusinessController@getId');
    Route::get('/plan/{monitor}', 'App\Http\Controllers\ServersController@getMonitor');
    Route::post('/business/{business}/{monitor}/channel', 'App\Http\Controllers\ClientChannelsController@addClientChannels');
});

Route::controller(discordStrategiesController::class)->group(function () {

    Route::post('refresh', 'refresh');
    Route::get('me', 'me');

});
//Route::post('register', [UserController:: class,'register']);

//Route::post('/callback',[UserController::class, 'DiscoAuth']);

