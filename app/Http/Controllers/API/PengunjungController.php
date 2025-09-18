<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengunjungController extends Controller
{
    // Ambil semua data pengunjung
    public function read()
    {
        $pengunjung = DB::table('pengunjung')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pengunjung berhasil diambil',
            'pengunjung' => $pengunjung
        ]);
    }

    // Detail pengunjung by id
    public function detail($id)
    {
        $pengunjung = DB::table('pengunjung')->where('id', $id)->first();

        if (!$pengunjung) {
            return response()->json([
                'success' => false,
                'message' => 'Pengunjung tidak ditemukan'
            ], 404);
        }

        $memberSip = $pengunjung->id_member_sip ? DB::table('member_sip')->find($pengunjung->id_member_sip) : null;
        $metodePembayaran = $pengunjung->id_metode_pembayaran ? DB::table('metode_pembayarans')->find($pengunjung->id_metode_pembayaran) : null;

        return response()->json([
            'success' => true,
            'message' => 'Detail pengunjung berhasil diambil',
            'pengunjung' => $pengunjung,
            'member_sip' => $memberSip,
            'metode_pembayaran' => $metodePembayaran
        ]);
    }

    // Tambah data pengunjung
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_member_sip' => 'nullable|integer',
            'id_metode_pembayaran' => 'nullable|integer',
            'id_lokasi' => 'required|integer', // Menambah validasi
            'id_petugas' => 'required|integer', // Menambah validasi
            'id_jenis_kendaraan' => 'required|integer', // Menambah validasi
            'tarif' => 'nullable|numeric', // Menambah validasi
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_keluar' => 'nullable', // Menambah validasi
            'nopol' => 'required|string|max:20',
            'bukti_pembayaran' => 'nullable|string',
            'status' => 'nullable|in:sudah_bayar,belum_bayar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $id = DB::table('pengunjung')->insertGetId([
            'id_member_sip' => $request->id_member_sip,
            'id_metode_pembayaran' => $request->id_metode_pembayaran,
            'id_lokasi' => $request->id_lokasi,
            'id_petugas' => $request->id_petugas,
            'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
            'tarif' => $request->tarif,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'nopol' => $request->nopol,
            'bukti_pembayaran' => $request->bukti_pembayaran,
            'status' => $request->status ?? 'belum_bayar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pengunjung berhasil ditambahkan',
            'id' => $id
        ], 201);
    }

    // Update data pengunjung
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_member_sip' => 'nullable|integer',
            'id_metode_pembayaran' => 'nullable|integer',
            'id_lokasi' => 'sometimes|integer',
            'id_petugas' => 'sometimes|integer',
            'id_jenis_kendaraan' => 'sometimes|integer',
            'tarif' => 'nullable|numeric',
            'tanggal' => 'sometimes|date',
            'jam_masuk' => 'sometimes',
            'jam_keluar' => 'nullable',
            'nopol' => 'sometimes|string|max:20',
            'bukti_pembayaran' => 'nullable|string',
            'status' => 'nullable|in:sudah_bayar,belum_bayar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $affected = DB::table('pengunjung')->where('id', $id)->update([
            'id_member_sip' => $request->id_member_sip,
            'id_metode_pembayaran' => $request->id_metode_pembayaran,
            'id_lokasi' => $request->id_lokasi,
            'id_petugas' => $request->id_petugas,
            'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
            'tarif' => $request->tarif,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'nopol' => $request->nopol,
            'bukti_pembayaran' => $request->bukti_pembayaran,
            'status' => $request->status ?? 'belum_bayar',
            'updated_at' => now(),
        ]);

        if ($affected) {
            return response()->json([
                'success' => true,
                'message' => 'Data pengunjung berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan atau tidak ada perubahan'
            ], 404);
        }
    }

    // Hapus data pengunjung
    public function delete($id)
    {
        $deleted = DB::table('pengunjung')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Data pengunjung berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    // Ambil data member_sip
    public function getMemberSip()
    {
        $members = DB::table('member_sip')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data member_sip berhasil diambil',
            'members' => $members
        ]);
    }

    // Ambil data metode_pembayaran
    public function getMetodePembayaran()
    {
        $metode = DB::table('metode_pembayarans')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data metode_pembayaran berhasil diambil',
            'metode' => $metode
        ]);
    }
}
