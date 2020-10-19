<?php

use App\Http\Controllers\Frontend\AbsensiController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\MateriController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
// Route::get('contact', [ContactController::class, 'index'])->name('contact');
// Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/qrcode/{code}', function ($code) {
    return barcode_class($code)->html;
})->name('genqr');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/scan', [DashboardController::class, 'scanAbsen'])->name('scan');
    Route::post('/scan', [DashboardController::class, 'scanAbsen'])->name('scan');

    Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    // rating
    Route::get('rating', [HomeController::class, 'rating'])->name('rating.form');
    Route::post('rating', [HomeController::class, 'rating'])->name('rating.post');
});
/*
* These frontend controllers require the user to be logged in
* All route names are prefixed with 'frontend.'
* These routes can not be hit if the password is expired
*/
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        

        
        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
});
