<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TransactionController;

Route::post('/users',[UserController::class,'store']);
Route::get('/users',[UserController::class,'index']);
Route::post('/transactions',[TransactionController::class,'store']);
Route::get('/users/{id}/transactions',[TransactionController::class,'getByUser']);
Route::get('/users/{id}/balance',[TransactionController::class,'getBalance']);
