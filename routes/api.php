<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NavaController;
use App\Http\Controllers\Auth\RefreshTokenController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1'] , function(){
    Route::group(['middleware' => ['auth' , 'ip-restricted']] , function(){

        Route::post('content/list', [NavaController::class , 'index'])->name('content.index');

        Route::resource('content', NavaController::class)->parameters([
            'content' => 'nava'
        ])->except(['index']);
    
    });
    
    
    // ========================== Login ===========================  
    Route::post("login", [LoginController::class , 'login']);

    // ========================== Refresh ===========================  
    Route::get("refresh", [RefreshTokenController::class , 'refresh']);

});