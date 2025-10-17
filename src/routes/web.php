<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

Route::get('/',[ItemController::class,'index']);
Route::get('/search',[ItemController::class,'search']);
Route::get('/item/{id}',[ItemController::class,'show']);

Route::middleware('auth')->group(function(){
    Route::get('/mypage/profile',[ProfileController::class,'show']);
    Route::post('/profile_update',[ProfileController::class,'update']);
});