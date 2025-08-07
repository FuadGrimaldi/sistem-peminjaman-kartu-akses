<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\KartuAksesController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Hc\PeminjamanController as HcPeminjamanController;
use App\Http\Controllers\Sekretaris\PeminjamanController as SekrePeminjamanController;
use App\Http\Controllers\Sekretaris\KartuAksesController as SekreKartuAksesController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'user-access:manager'])->group(function () {
  
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});


  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/kartu-akses', [KartuAksesController::class, 'index'])->name('admin.kartu-akses');
    Route::get('/admin/kartu-akses/create', [KartuAksesController::class, 'create'])->name('admin.kartu-akses.create');
    Route::post('/admin/kartu-akses/store', [KartuAksesController::class, 'store'])->name('admin.kartu-akses.store');
    Route::get('/admin/kartu-akses/edit/{id}', [KartuAksesController::class, 'edit'])->name('admin.kartu-akses.edit');
    Route::put('/admin/kartu-akses/update/{id}', [KartuAksesController::class, 'update'])->name('admin.kartu-akses.update');
    Route::delete('/admin/kartu-akses/delete/{id}', [KartuAksesController::class, 'destroy'])->name('admin.kartu-akses.delete');


    Route::get('/admin/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman');
    Route::get('/admin/peminjaman/create', [PeminjamanController::class, 'create'])->name('admin.peminjaman.create');
    Route::post('/admin/peminjaman/store', [PeminjamanController::class, 'store'])->name('admin.peminjaman.store');
    Route::get('/admin/peminjaman/edit/{id}', [PeminjamanController::class, 'edit'])->name('admin.peminjaman.edit');
    Route::put('/admin/peminjaman/update/{id}', [PeminjamanController::class, 'update'])->name('admin.peminjaman.update');
    Route::delete('/admin/peminjaman/delete/{id}', [PeminjamanController::class, 'destroy'])->name('admin.peminjaman.delete');
    Route::get('/admin/peminjaman/show/{id}', [PeminjamanController::class, 'show'])->name('admin.peminjaman.show');


    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');
    Route::get('/admin/users/reset-password/{id}', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:hc'])->group(function () {
  
    Route::get('/hc/home', [HomeController::class, 'hcHome'])->name('hc.home');
    Route::get('/hc/peminjaman', [HcPeminjamanController::class, 'index'])->name('hc.peminjaman');
    Route::get('/hc/peminjaman/create', [HcPeminjamanController::class, 'create'])->name('hc.peminjaman.create');
    Route::post('/hc/peminjaman/store', [HcPeminjamanController::class, 'store'])->name('hc.peminjaman.store');
    Route::get('/hc/peminjaman/show/{id}', [HcPeminjamanController::class, 'show'])->name('hc.peminjaman.show');
});

Route::middleware(['auth', 'user-access:sekretaris'])->group(function () {
  
    Route::get('/sekre/home', [HomeController::class, 'sekreHome'])->name('sekre.home');
    Route::get('/sekre/peminjaman', [SekrePeminjamanController::class, 'index'])->name('sekre.peminjaman');
    Route::get('/sekre/peminjaman/show/{id}', [SekrePeminjamanController::class, 'show'])->name('sekre.peminjaman.show');
    Route::get('/sekre/peminjaman/approval/{id}', [SekrePeminjamanController::class, 'approval'])->name('sekre.peminjaman.approval');
    Route::put('/sekre/peminjaman/update-status/{id}', [SekrePeminjamanController::class, 'updateStatus'])->name('sekre.peminjaman.update-status');
    Route::get('/sekre/peminjaman/pengembalian-hilang/{id}', [SekrePeminjamanController::class, 'ShowPengembalianHilang'])->name('sekre.peminjaman.pengembalian-hilang');
    Route::put('/sekre/peminjaman/update-status-pengembalian-hilang/{id}', [SekrePeminjamanController::class, 'updateStatusPengembalianHilang'])->name('sekre.peminjaman.update-status-pengembalian-hilang');   

    Route::get('/sekre/kartu-akses', [SekreKartuAksesController::class, 'index'])->name('sekre.kartu-akses');
    Route::get('/sekre/kartu-akses/create', [SekreKartuAksesController::class, 'create'])->name('sekre.kartu-akses.create');
    Route::post('/sekre/kartu-akses/store', [SekreKartuAksesController::class, 'store'])->name('sekre.kartu-akses.store');
    Route::get('/sekre/kartu-akses/edit/{id}', [SekreKartuAksesController::class, 'edit'])->name('sekre.kartu-akses.edit');
    Route::put('/sekre/kartu-akses/update/{id}', [SekreKartuAksesController::class, 'update'])->name('sekre.kartu-akses.update');
    Route::delete('/sekre/kartu-akses/delete/{id}', [SekreKartuAksesController::class, 'destroy'])->name('sekre.kartu-akses.delete');   
});


