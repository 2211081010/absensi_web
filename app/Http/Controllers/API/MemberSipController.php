<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberSipController extends Controller
{
    /**
     * GET /api/member-sip
     * Ambil semua member
     */
    public function index()
    {
        $members = DB::table('member_sip')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data member berhasil diambil',
            'data'    => $members,
        ], 200);
    }

    /**
     * POST /api/member-sip
     * Tambah member baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'                 => 'required|string|max:255',
            'nohp'                 => 'required|string|max:20',
            'id_metode_pembayaran' => 'required|integer|exists:metode_pembayaran,id',
            'foto'                 => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $id = DB::table('member_sip')->insertGetId($validator->validated());
        $member = DB::table('member_sip')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data member berhasil ditambahkan',
            'data'    => $member,
        ], 201);
    }

    /**
     * GET /api/member-sip/{id}
     * Tampilkan detail member
     */
    public function show($id)
    {
        $member = DB::table('member_sip')->where('id', $id)->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Data member tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail member berhasil diambil',
            'data'    => $member,
        ], 200);
    }

    /**
     * PUT /api/member-sip/{id}
     * Update data member
     */
    public function update(Request $request, $id)
    {
        $member = DB::table('member_sip')->where('id', $id)->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Data member tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'                 => 'required|string|max:255',
            'nohp'                 => 'required|string|max:20',
            'id_metode_pembayaran' => 'required|integer|exists:metode_pembayaran,id',
            'foto'                 => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::table('member_sip')->where('id', $id)->update($validator->validated());
        $member = DB::table('member_sip')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data member berhasil diperbarui',
            'data'    => $member,
        ], 200);
    }

    /**
     * DELETE /api/member-sip/{id}
     * Hapus data member
     */
    public function destroy($id)
    {
        $member = DB::table('member_sip')->where('id', $id)->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Data member tidak ditemukan',
            ], 404);
        }

        DB::table('member_sip')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data member berhasil dihapus',
        ], 200);
    }
}
