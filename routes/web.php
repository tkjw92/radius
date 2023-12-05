<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VPNController;
use App\Models\VPNModel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'dashboard']);
Route::get('/router', [DashboardController::class, 'router']);
Route::get('/pppoe/profile', [DashboardController::class, 'profile']);
Route::get('/pppoe/user', [DashboardController::class, 'user']);
Route::get('/router/script/{version}/{id}', [VPNController::class, 'script']);

Route::post('/router/add', [VPNController::class, 'add']);
Route::post('/pppoe/profile/add', [ProfileController::class, 'add']);
Route::post('/pppoe/profile/delete', [ProfileController::class, 'delete']);
Route::post('/pppoe/user/add', [UserController::class, 'add']);
Route::post('/pppoe/user/delete', [UserController::class, 'delete']);
Route::post('/pppoe/profile/update', [ProfileController::class, 'update']);
Route::post('/pppoe/user/update', [UserController::class, 'update']);

Route::post('/router/delete', [VPNController::class, 'delete']);
Route::post('/router/delete', [VPNController::class, 'disable']);
