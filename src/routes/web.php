<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

Route::get('/profile',[UserController::class,'profile']);
Route::get('/',[ItemController::class,'index']);
