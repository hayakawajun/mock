<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShippingAddressController;


Route::get('/',[ItemController::class,'index'])->name('item.index');
Route::get('/search',[ItemController::class,'search'])->name('item.search');
Route::get('/item/{id}',[ItemController::class,'show'])->name('item.show');

Route::middleware('auth')->group(function(){
    Route::get('/mypage',[ProfileController::class,'index'])->name('profile.index');
    Route::get('/mypage/profile',[ProfileController::class,'show'])->name('profile.show');
    Route::post('/profile_update',[ProfileController::class,'update'])->name('profile.update');

    Route::post('/like/{item}',[LikeController::class,'toggle'])->name('like.toggle');

    Route::post('/post',[CommentController::class,'store'])->name('comment.post');

    Route::get('/purchase/{item}',[PurchaseController::class,'order'])->name('item.order');
    Route::post('/payment',[PurchaseController::class,'createCheckoutSession'])->name('item.payment');

    Route::get('/purchase/address/create/{item}',[ShippingAddressController::class,'create'])->name('address.create');
    Route::post('/purchase/address/store/{item}',[ShippingAddressController::class,'store'])->name('address.store');
    Route::get('/purchase/address/edit/{item}/{shippingAddress}',[ShippingAddressController::class,'edit'])->name('address.edit');
    Route::patch('/purchase/address/update/{item}',[ShippingAddressController::class,'addressUpdate'])->name('address.update');
    Route::get('/purchase/address/delete/{item}/{shippingAddress}',[ShippingAddressController::class,'destroy'])->name('address.delete');


    Route::get('/payment/success', [PurchaseController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PurchaseController::class, 'cancel'])->name('payment.cancel');
});