<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\GoalController;

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


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('user',[UserController::class,'index']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('wallet',[WalletController::class,'index']);
    Route::post('transfer',[TransferController::class,'store']);
    Route::post('create/target',[GoalController::class,'store']);
    Route::delete('delete/target/{id}',[GoalController::class,'store']);
});


