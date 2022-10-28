<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobsController;

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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
   
});
Route::post('store', [JobsController::class, 'storeData']);
Route::get('store/all', [JobsController::class, 'getAllStoreData']);
Route::get('store/{id}', [JobsController::class, 'getStoreData']);
Route::post('store/{id}', [JobsController::class, 'updateStoreData']);
Route::delete('store/{id}', [JobsController::class, 'deleteStoreData']);