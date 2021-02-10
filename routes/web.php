<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\Authenticate;

Route::get('/logout',[LoginController::class,'logout']);
Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login',[LoginController::class,'validateLogin']);

Route::middleware([Authenticate::class])->group(function () {
    Route::get('/',[HomeController::class,'index'])->name('home');

    //manage files
    Route::post('/upload/{id}',[FileController::class,'store'])->name('upload');
    Route::get('/download/{id}',[FileController::class,'download'])->name('download');
    Route::get('/delete/{id}',[FileController::class,'destroy'])->name('destroy');

    //manage nodes
    Route::get('/folders',[NodeController::class,'index']);
    Route::post('/folders/update',[NodeController::class,'update'])->name('update.folder');
    Route::post('/node/create/{id}',[NodeController::class,'create'])->name('add.node');
    Route::post('/node/destroy',[NodeController::class,'destroy'])->name('delete.node');

    //manage users
    Route::get('/users',[UserController::class,'index'])->name('users');
    Route::post('/users/add',[UserController::class,'add'])->name('add.access');
    Route::post('/users/destroy',[UserController::class,'destroy']);


    Route::get('/load/{id}',[LoadController::class,'index']);
});

