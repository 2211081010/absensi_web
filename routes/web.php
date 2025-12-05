<?php

use App\Http\Controllers\Admin\AbsensiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\JenisKendaraanController;
use App\Http\Controllers\Admin\KantorController;
use App\Http\Controllers\Admin\KendaraanMemberController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\LokasiPetugasController;
use App\Http\Controllers\Admin\MemberSipController;
use App\Http\Controllers\Admin\MetodePembayaranController;
use App\Http\Controllers\Admin\PengunjungController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\PegawaiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Clear All:
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('optimize');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Berhasil dibersihkan</h1>';
});

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/keluar', [HomeController::class, 'keluar']);
Route::get('/admin/home', [HomeController::class, 'index']);
Route::get('/admin/change', [HomeController::class, 'change']);
Route::post('/admin/change_password', [HomeController::class, 'change_password']);

// Account
Route::prefix('admin/account')
    ->name('admin.account.')
    ->middleware('cekLevel:1 2')
    ->controller(AccountController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/reset/{id}', 'reset')->name('reset'); // Hanya untuk Account
    });

    // Petugas
    Route::prefix('admin/petugas')
    ->name('admin.petugas.')
    ->middleware('cekLevel:1 2')
    ->controller(PetugasController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });
Route::prefix('admin/pegawai')->group(function () {
    Route::get('/', [PegawaiController::class, 'index'])->name('admin.pegawai.index');
    Route::get('/add', [PegawaiController::class, 'create'])->name('admin.pegawai.create');
    Route::post('/store', [PegawaiController::class, 'store'])->name('admin.pegawai.store');
    Route::get('/edit/{id}', [PegawaiController::class, 'edit'])->name('admin.pegawai.edit');
    Route::post('/update/{id}', [PegawaiController::class, 'update'])->name('admin.pegawai.update');
    Route::get('/delete/{id}', [PegawaiController::class, 'delete'])->name('admin.pegawai.delete');
});
// Absensi
Route::prefix('admin/absensi')
    ->name('admin.absensi.')
    ->middleware('auth')
    ->controller(App\Http\Controllers\Admin\AbsensiController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/add', 'create')->name('add');
        Route::post('/create', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');


    });

