<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
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

// Route::get('/login', function () {
//     return view('welcome');
// });

Route::get('/register', [AuthController::class, 'register']);
Route::post('/setToken', [AuthController::class, 'setToken']);
Route::get('/', [AuthController::class, 'login']);
Route::get('/dashboard', [MainController::class, 'index']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/purchase', [MainController::class, 'purchase']);
Route::get('/goods', [MainController::class, 'goods']);
Route::get('/excel', [MainController::class, 'excel']);
Route::get('/pdf', [MainController::class, 'pdf']);
