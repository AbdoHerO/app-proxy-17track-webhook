<?php

use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

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

Route::post('/webhook/17track', [WebhookController::class,'handle17TrackWebhook'])->name('17trackwebhook');
Route::match(['get', 'post'], '/tracking', [TrackingController::class,'index'])->name('tracking');
Route::get('/fetch-tracking-data', [TrackingController::class, 'fetchTrackingData']);

// Route::post('/webhook/17track', 'WebhookController@handle17TrackWebhook');

