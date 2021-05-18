<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GatewayController;
use App\Http\Controllers\API\TransactionController;

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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'create']);

Route::group(['domain'=> config('app.url'), 'middleware' => 'auth:api'], function () {
    Route::get('/me', [UserController::class, 'index']);

    /**
     * Gateway
     */

    Route::get('/gateway/list', [GatewayController::class, 'index']);

    /**
     * Transactions
     */

    Route::get('/transaction/list', [TransactionController::class, 'index']);
    Route::post('/transaction/make', [TransactionController::class, 'make']);
    Route::post('/transaction/cancel', [TransactionController::class, 'cancel']);
});

Route::post('/transaction/update', [TransactionController::class, 'update']);
