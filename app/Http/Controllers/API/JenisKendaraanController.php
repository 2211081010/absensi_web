<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JenisKendaraanController extends Controller
{
    /**
     * GET /api/jenis-kendaraan
     * Ambil semua jenis kendaraan
     */
    public function index()
    {
        $data = DB::table('jenis_kendaraan')->orderBy('id', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data jenis kendaraan berhasil diambil',
            'data'    => $data,
        ], 200);
    }

    /**
     * POST /api/jenis-kendaraan
     * Simpan jenis kendaraan baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kendaraan' => 'required|string|max:255',
            'tarif'           => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $id = DB::table('jenis_kendaraan')->insertGetId($validator->validated());
        $newData = DB::table('jenis_kendaraan')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Jenis kendaraan berhasil ditambahkan',
            'data'    => $newData,
        ], 201);
    }

    /**
     * GET /api/jenis-kendaraan/{id}
     * Detail jenis kendaraan
     */
    public function show($id)
    {
        $data = DB::table('jenis_kendaraan')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis kendaraan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail jenis kendaraan berhasil diambil',
            'data'    => $data,
        ], 200);
    }

    /**
     * PUT /api/jenis-kendaraan/{id}
     * Update jenis kendaraan
     */
    public function update(Request $request, $id)
    {
        $data = DB::table('jenis_kendaraan')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis kendaraan tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'jenis_kendaraan' => 'required|string|max:255',
            'tarif'           => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::table('jenis_kendaraan')->where('id', $id)->update($validator->validated());
        $updated = DB::table('jenis_kendaraan')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data jenis kendaraan berhasil diperbarui',
            'data'    => $updated,
        ], 200);
    }

    /**
     * DELETE /api/jenis-kendaraan/{id}
     * Hapus jenis kendaraan
     */
    public function destroy($id)
    {
        $data = DB::table('jenis_kendaraan')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis kendaraan tidak ditemukan',
            ], 404);
        }

        DB::table('jenis_kendaraan')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data jenis kendaraan berhasil dihapus',
        ], 200);
    }
}
