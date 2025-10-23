<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;


Route::get('/',[ItemController::class,'index'])->name('item.index');
Route::get('/search',[ItemController::class,'search'])->name('item.search');
Route::get('/item/{id}',[ItemController::class,'show'])->name('item.show');

Route::middleware('auth')->group(function(){
    Route::get('/mypage/profile',[ProfileController::class,'show'])->name('profile.show');
    Route::post('/profile_update',[ProfileController::class,'update'])->name('profile.update');
    Route::post('/like/{item}',[LikeController::class,'toggle'])->name('like.toggle');
    Route::post('/post',[CommentController::class,'store'])->name('comment.post');
    Route::get('/purchase/{item}',[PurchaseController::class,'order'])->name('item.order');
});