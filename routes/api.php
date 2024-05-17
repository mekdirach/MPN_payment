<?php

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TrasaksiAhuControllerApi;
use App\Http\Controllers\Api\TrasaksiNonAhuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [RegisterController::class, 'logout']);
});
Route::get('items', [ItemController::class, 'index']);
Route::get('items/search', [ItemController::class, 'search']);

//TransaksiAHU
Route::get('transaksiAhu', [TrasaksiAhuControllerApi::class, 'index']);
Route::get('holidays', [TrasaksiAhuControllerApi::class, 'store']);
//TransaksiAHU
Route::get('transaksiNonAhu', [TrasaksiNonAhuController::class, 'index']);
