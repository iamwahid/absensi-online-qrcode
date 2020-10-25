<?php

use App\Http\Controllers\Backend\AbsensiController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DosenController;
use App\Http\Controllers\Backend\JadwalController;
use App\Http\Controllers\Backend\RatingController;
use App\Http\Controllers\Backend\MahasiswaController;
use App\Http\Controllers\Backend\MataKuliahController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'mahasiswa'], function() {
  Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
  Route::get('/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
  Route::post('/', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

  Route::group(['prefix' => '/{mahasiswa}'], function(){
    Route::get('/', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::post('/', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/', [MahasiswaController::class, 'destroy'])->name('mahasiswa.delete');
  });
});

Route::group(['prefix' => 'dosen'], function() {
  Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
  Route::get('/create', [DosenController::class, 'create'])->name('dosen.create');
  Route::post('/', [DosenController::class, 'store'])->name('dosen.store');

  Route::group(['prefix' => '/{dosen}'], function(){
    Route::get('/', [DosenController::class, 'show'])->name('dosen.show');
    Route::get('/edit', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::post('/', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('/', [DosenController::class, 'destroy'])->name('dosen.delete');
  });
});

Route::group(['prefix' => 'mata_kuliah'], function() {
  Route::get('/', [MataKuliahController::class, 'index'])->name('mata_kuliah.index');
  Route::get('/create', [MataKuliahController::class, 'create'])->name('mata_kuliah.create');
  Route::post('/', [MataKuliahController::class, 'store'])->name('mata_kuliah.store');

  Route::group(['prefix' => '/{mata_kuliah}'], function(){
    Route::get('/', [MataKuliahController::class, 'show'])->name('mata_kuliah.show');
    Route::get('/edit', [MataKuliahController::class, 'edit'])->name('mata_kuliah.edit');
    Route::post('/', [MataKuliahController::class, 'update'])->name('mata_kuliah.update');
    Route::get('/dosen', [MataKuliahController::class, 'dosen'])->name('mata_kuliah.dosen');
    Route::post('/dosen', [MataKuliahController::class, 'dosen'])->name('mata_kuliah.dosen');
    Route::get('/dosen-json', [MataKuliahController::class, 'dosenJson'])->name('mata_kuliah.dosenJson');
    Route::delete('/', [MataKuliahController::class, 'destroy'])->name('mata_kuliah.delete');
  });
});

Route::group(['prefix' => 'jadwal', 'as' => 'jadwal.'], function() {
  Route::get('/', [JadwalController::class, 'index'])->name('index');
  Route::get('/create', [JadwalController::class, 'create'])->name('create');
  Route::post('/', [JadwalController::class, 'store'])->name('store');

  Route::group(['prefix' => '/{jadwal}'], function(){
    Route::group(['prefix' => 'absensi'], function() {
      Route::get('/', [JadwalController::class, 'absensi'])->name('absensi.index');
      Route::get('/{mahasiswa}', [JadwalController::class, 'absensiMhs'])->name('absensi.mhs');
      Route::post('/{mahasiswa}/absen', [JadwalController::class, 'absensiMhsSave'])->name('absensi.mhs');
    });

    Route::get('/', [JadwalController::class, 'show'])->name('show');
    Route::get('/edit', [JadwalController::class, 'edit'])->name('edit');
    Route::post('/', [JadwalController::class, 'update'])->name('update');
    Route::get('/mahasiswa', [JadwalController::class, 'mahasiswa'])->name('mahasiswa');
    Route::post('/mahasiswa', [JadwalController::class, 'mahasiswa'])->name('mahasiswa');
    Route::delete('/', [JadwalController::class, 'destroy'])->name('delete');
  });
});

Route::group(['prefix' => 'rating'], function() {
  Route::get('/', [RatingController::class, 'index'])->name('rating.index');
});