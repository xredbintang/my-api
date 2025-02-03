<?php

use App\Http\Controllers\productNotController;
use App\Http\Controllers\redisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'testing'], function(){
    Route::get('/redis',[redisController::class,'index'])->name('cache');
    Route::get('/blader',[productNotController::class,'index'])->name('blader');
});