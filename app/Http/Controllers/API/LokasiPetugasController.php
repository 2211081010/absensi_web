<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LokasiPetugasController extends Controller
{
    /**
     * GET /api/lokasi-petugas
     * Ambil semua data lokasi petugas dengan detail lokasi dan petugas.
     */
    public function index()
    {
        $lokasiPetugas = DB::table('lokasi_petugas')
            ->join('lokasi', 'lokasi_petugas.id_lokasi', '=', 'lokasi.id')
            ->join('petugas', 'lokasi_petugas.id_petugas', '=', 'petugas.id')
            ->select(
                'lokasi_petugas.id',
                'lokasi.nama as nama_lokasi',
                'lokasi.alamat as alamat_lokasi',
                'petugas.nama as nama_petugas',
                'lokasi_petugas.created_at',
                'lokasi_petugas.updated_at'
            )
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data lokasi petugas berhasil diambil',
            'data'    => $lokasiPetugas,
        ], 200);
    }

    /**
     * POST /api/lokasi-petugas
     * Simpan data lokasi petugas baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_lokasi'  => 'required|integer|exists:lokasi,id',
            'id_petugas' => 'required|integer|exists:petugas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $id = DB::table('lokasi_petugas')->insertGetId($validator->validated());
        $lokasiPetugas = DB::table('lokasi_petugas')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data lokasi petugas berhasil ditambahkan',
            'data'    => $lokasiPetugas,
        ], 201);
    }

    /**
     * GET /api/lokasi-petugas/{id}
     * Tampilkan detail lokasi petugas.
     */
    public function show($id)
    {
        $lokasiPetugas = DB::table('lokasi_petugas')
            ->join('lokasi', 'lokasi_petugas.id_lokasi', '=', 'lokasi.id')
            ->join('petugas', 'lokasi_petugas.id_petugas', '=', 'petugas.id')
            ->select(
                'lokasi_petugas.id',
                'lokasi.nama as nama_lokasi',
                'lokasi.alamat as alamat_lokasi',
                'petugas.nama as nama_petugas',
                'lokasi_petugas.created_at',
                'lokasi_petugas.updated_at'
            )
            ->where('lokasi_petugas.id', $id)
            ->first();

        if (!$lokasiPetugas) {
            return response()->json([
                'success' => false,
                'message' => 'Data lokasi petugas tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail lokasi petugas berhasil diambil',
            'data'    => $lokasiPetugas,
        ], 200);
    }

    /**
     * PUT /api/lokasi-petugas/{id}
     * Update data lokasi petugas.
     */
    public function update(Request $request, $id)
    {
        $lokasiPetugas = DB::table('lokasi_petugas')->where('id', $id)->first();

        if (!$lokasiPetugas) {
            return response()->json([
                'success' => false,
                'message' => 'Data lokasi petugas tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_lokasi'  => 'required|integer|exists:lokasi,id',
            'id_petugas' => 'required|integer|exists:petugas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::table('lokasi_petugas')->where('id', $id)->update($validator->validated());
        $updatedLokasiPetugas = DB::table('lokasi_petugas')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data lokasi petugas berhasil diperbarui',
            'data'    => $updatedLokasiPetugas,
        ], 200);
    }

    /**
     * DELETE /api/lokasi-petugas/{id}
     * Hapus data lokasi petugas.
     */
    public function destroy($id)
    {
        $lokasiPetugas = DB::table('lokasi_petugas')->where('id', $id)->first();

        if (!$lokasiPetugas) {
            return response()->json([
                'success' => false,
                'message' => 'Data lokasi petugas tidak ditemukan',
            ], 404);
        }

        DB::table('lokasi_petugas')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data lokasi petugas berhasil dihapus',
        ], 200);
    }
}
