<?php

use App\Http\Controllers\Backend\Auth\Role\RoleController;
use App\Http\Controllers\Backend\Auth\User\UserController;
use App\Http\Controllers\Backend\BimbinganController;
use App\Http\Controllers\Frontend\Auth\ApiLoginController;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [ApiLoginController::class, 'login']);
    Route::post('signup', [ApiLoginController::class, 'signup']);
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [ApiLoginController::class, 'logout']);
        Route::post('refresh', [ApiLoginController::class, 'refresh']);
        Route::get('users', [UserController::class, 'indexJson']);
        Route::get('user/{id}', [UserController::class, 'showJson']);
        Route::get('roles', [RoleController::class, 'indexJson']);
    });
});