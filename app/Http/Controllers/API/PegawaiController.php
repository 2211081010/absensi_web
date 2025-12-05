<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    // Ambil data pegawai berdasarkan token user
    public function byUser(Request $request)
    {
        $userId = $request->user()->id; // Ambil dari token
        $pegawai = DB::table('pegawai')->where('id_user', $userId)->first();

        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data pegawai berhasil diambil',
            'data' => $pegawai
        ], 200);
    }
}
