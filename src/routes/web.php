<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

Route::get('/',[ItemController::class,'index']);

Route::middleware('auth')->group(function(){
    Route::get('/profile',[ProfileController::class,'profile']);
    Route::post('/profile_update',[ProfileController::class,'update']);
});