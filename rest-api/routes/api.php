<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StudentsController;
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
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('goods/findAll', [GoodsController::class, 'findAll']);
    Route::post('goods/findById', [GoodsController::class, 'findById']);
    Route::post('goods/delete', [GoodsController::class, 'delete']);
    Route::post('goods/findByProductName', [GoodsController::class, 'findByProductName']);

    Route::post('purchase/create', [PurchaseController::class, 'create']);
    Route::get('purchase/findAll', [PurchaseController::class, 'findAll']);
    Route::post('purchase/debug', [PurchaseController::class, 'debug']);
    Route::post('purchase/findById', [PurchaseController::class, 'findById']);
    Route::post('purchase/findByProductName', [PurchaseController::class, 'findByProductName']);
    Route::post('purchase/delete', [PurchaseController::class, 'delete']);
    Route::post('purchase/update', [PurchaseController::class, 'update']);
});
Route::get('purchase/reportExcel', [PurchaseController::class, 'excel']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
