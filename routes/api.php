<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ApI\PengunjungController;
use App\Http\Controllers\ApI\JenisKendaraanController;
use App\Http\Controllers\ApI\LokasiPetugasController;
use App\Http\Controllers\ApI\MetodePembayaranController;
use App\Http\Controllers\Api\MemberSipController;
use App\Http\Controllers\Api\PetugasController;

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


// Route::get('/petugas', [PetugasController::class, 'index']);
// Route::post('/petugas', [PetugasController::class, 'store']);
// Route::get('/petugas/{id}', [PetugasController::class, 'show']);
// Route::put('/petugas/{id}', [PetugasController::class, 'update']);
// Route::delete('/petugas/{id}', [PetugasController::class, 'destroy']);

