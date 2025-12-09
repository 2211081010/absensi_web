<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ApI\PengunjungController;
use App\Http\Controllers\ApI\JenisKendaraanController;
use App\Http\Controllers\ApI\LokasiPetugasController;
use App\Http\Controllers\ApI\MetodePembayaranController;
use App\Http\Controllers\Api\MemberSipController;
use App\Http\Controllers\Api\PegawaiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth API
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');



Route::get('/pengunjung', [PengunjungController::class, 'read']);
Route::get('/pengunjung/{id}', [PengunjungController::class, 'detail']);
Route::post('/pengunjung', [PengunjungController::class, 'create']);
Route::put('/pengunjung/{id}', [PengunjungController::class, 'update']);
Route::delete('/pengunjung/{id}', [PengunjungController::class, 'delete']);

// opsional
Route::get('/member-sip', [PengunjungController::class, 'getMemberSip']);
Route::get('/metode-pembayaran', [PengunjungController::class, 'getMetodePembayaran']);




// Route::prefix('JenisKendaraan')->group(function () {
Route::prefix('jeniskendaraan')->group(function () {
    Route::get('/', [JenisKendaraanController::class, 'index']);
    Route::post('/', [JenisKendaraanController::class, 'store']);
    Route::get('/{id}', [JenisKendaraanController::class, 'show']);
    Route::put('/{id}', [JenisKendaraanController::class, 'update']);
    Route::delete('/{id}', [JenisKendaraanController::class, 'destroy']);

});


Route::apiResource('lokasi', LokasiPetugasController::class);



Route::get('metodepembayaran', [MetodePembayaranController::class, 'index']);
Route::post('metodepembayaran', [MetodePembayaranController::class, 'store']);
Route::get('metodepembayaran/{id}', [MetodePembayaranController::class, 'show']);
Route::put('metodepembayaran/{id}', [MetodePembayaranController::class, 'update']);
Route::delete('metodepembayaran/{id}', [MetodePembayaranController::class, 'destroy']);

Route::apiResource('membersip', MemberSipController::class);

use App\Http\Controllers\Api\AbsensiController;

Route::prefix('absensi')->group(function () {
    Route::get('/', [AbsensiController::class, 'index']);          // list absensi
    Route::post('/create', [AbsensiController::class, 'create']);  // tambah absensi
    Route::get('/show/{id}', [AbsensiController::class, 'show']);  // detail
    Route::post('/update/{id}', [AbsensiController::class, 'update']); // update absensi
    Route::delete('/delete/{id}', [AbsensiController::class, 'delete']); // delete absensi
});


Route::post('login', [AuthController::class, 'login']);

// Middleware auth:sanctum untuk proteksi
Route::middleware('auth:sanctum')->group(function () {
    Route::get('pegawai/by-user', [PegawaiController::class, 'byUser']);
    Route::post('/pegawai/update', [PegawaiController::class, 'updateProfile']);
    Route::post('/pegawai/update-foto', [PegawaiController::class, 'updateFoto']);
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pegawai/me', [PegawaiController::class, 'byUser']);
    Route::get('/absensi/today/{id}', [AbsensiController::class, 'today']);

    Route::post('/absensi/create', [AbsensiController::class, 'create']);
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang']);
});

