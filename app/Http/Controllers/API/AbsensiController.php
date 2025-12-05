<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // ======================
    // GET: Semua Absensi
    // ======================
    public function index()
    {
        $data = DB::table('absensi')
            ->join('pegawai', 'pegawai.id', '=', 'absensi.id_pegawai')
            ->select(
                'absensi.*',
                'pegawai.nama as nama_pegawai',
                'pegawai.nip'
            )
            ->orderBy('absensi.id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // ======================
    // GET: Detail Absensi
    // ======================
    public function show($id)
    {
        $data = DB::table('absensi')
            ->join('pegawai', 'pegawai.id', '=', 'absensi.id_pegawai')
            ->select(
                'absensi.*',
                'pegawai.nama as nama_pegawai',
                'pegawai.nip'
            )
            ->where('absensi.id', $id)
            ->first();

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['status' => true, 'data' => $data]);
    }

    // ======================
    // GET: Status Hari Ini
    // ======================
    public function today($id)
    {
        $today = Carbon::today()->toDateString(); // YYYY-MM-DD

        $absen = DB::table('absensi')
            ->where('id_pegawai', $id)
            ->whereDate('tanggal', $today) // Pastikan hanya tanggal
            ->first();

        if (!$absen) {
            return response()->json([
                'status' => 'belum',
                'jam_masuk' => null,
                'jam_pulang' => null,
            ]);
        }

        $jamMasuk = $absen->jam_masuk ? date('H:i', strtotime($absen->jam_masuk)) : null;
        $jamPulang = $absen->jam_pulang ? date('H:i', strtotime($absen->jam_pulang)) : null;

        $status = 'belum';
        if ($jamMasuk && !$jamPulang) {
            $status = 'masuk';
        } else if ($jamMasuk && $jamPulang) {
            $status = 'pulang';
        }

        return response()->json([
            'status' => $status,
            'jam_masuk' => $jamMasuk,
            'jam_pulang' => $jamPulang,
        ]);
    }

    // ======================
    // POST: Absen Masuk
    // ======================
    public function create(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'foto_masuk' => 'nullable|image',
        ]);

        $today = date('Y-m-d');

        $cek = DB::table('absensi')
            ->where('id_pegawai', $request->id_pegawai)
            ->whereDate('tanggal', $today)
            ->first();

        if ($cek) {
            return response()->json([
                'status' => false,
                'message' => 'Anda sudah melakukan absen masuk'
            ]);
        }

        $fotoMasuk = null;
        if ($request->hasFile('foto_masuk')) {
            $fotoMasuk = $request->file('foto_masuk')->store('absensi/foto_masuk', 'public');
        }

        $id = DB::table('absensi')->insertGetId([
            'id_pegawai' => $request->id_pegawai,
            'tanggal' => $today,
            'jam_masuk' => date('H:i:s'),
            'status_masuk' => 'hadir',
            'foto_masuk' => $fotoMasuk,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Absen masuk berhasil',
            'id' => $id
        ]);
    }

    // ======================
    // POST: Absen Pulang
    // ======================
    public function pulang(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'foto_pulang' => 'nullable|image',
        ]);

        $today = date('Y-m-d');

        $absen = DB::table('absensi')
            ->where('id_pegawai', $request->id_pegawai)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absen) {
            return response()->json([
                'status' => false,
                'message' => 'Anda belum absen masuk'
            ]);
        }

        if ($absen->jam_pulang) {
            return response()->json([
                'status' => false,
                'message' => 'Anda sudah absen pulang'
            ]);
        }

        $fotoPulang = null;
        if ($request->hasFile('foto_pulang')) {
            $fotoPulang = $request->file('foto_pulang')->store('absensi/foto_pulang', 'public');
        }

        DB::table('absensi')
            ->where('id', $absen->id)
            ->update([
                'jam_pulang' => date('H:i:s'),
                'foto_pulang' => $fotoPulang,
                'status_pulang' => 'hadir',
                'updated_at' => now(),
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Absen pulang berhasil'
        ]);
    }
}
