<?php

use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/get_count_users', [UsersController::class, 'getCountUsers']);
Route::get('/import', [UsersController::class, 'importUsers']);
