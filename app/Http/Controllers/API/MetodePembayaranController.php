<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    /**
     * GET /api/metode-pembayaran
     * Ambil semua metode pembayaran
     */
    public function index()
    {
        $data = DB::table('metode_pembayarans')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data metode pembayaran berhasil diambil',
            'data'    => $data,
        ], 200);
    }

    /**
     * POST /api/metode-pembayaran
     * Simpan metode pembayaran baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_metode' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $id = DB::table('metode_pembayarans')->insertGetId($validator->validated());
        $data = DB::table('metode_pembayarans')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil ditambahkan',
            'data'    => $data,
        ], 201);
    }

    /**
     * GET /api/metode-pembayaran/{id}
     * Detail metode pembayaran
     */
    public function show($id)
    {
        $data = DB::table('metode_pembayarans')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail metode pembayaran',
            'data'    => $data,
        ], 200);
    }

    /**
     * PUT /api/metode-pembayaran/{id}
     * Update metode pembayaran
     */
    public function update(Request $request, $id)
    {
        $data = DB::table('metode_pembayarans')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_metode' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::table('metode_pembayarans')->where('id', $id)->update($validator->validated());
        $data = DB::table('metode_pembayarans')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil diperbarui',
            'data'    => $data,
        ], 200);
    }

    /**
     * DELETE /api/metode-pembayaran/{id}
     * Hapus metode pembayaran
     */
    public function destroy($id)
    {
        $data = DB::table('metode_pembayarans')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak ditemukan',
            ], 404);
        }

        DB::table('metode_pembayarans')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil dihapus',
        ], 200);
    }
}
