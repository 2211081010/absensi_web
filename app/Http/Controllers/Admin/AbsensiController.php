<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ================= List Semua Absensi =================
    public function index()
    {
        $absensi = DB::table('absensi')
            ->join('pegawai', 'absensi.id_pegawai', '=', 'pegawai.id')
            ->select(
                'absensi.*',
                'pegawai.nama as nama_pegawai',
                'pegawai.nip'
            )
            ->orderBy('absensi.id', 'DESC')
            ->get();

        return view('admin.absensi.index', ['absensi' => $absensi]);
    }

    // ================= Form Tambah Absensi =================
    public function create()
    {
        $pegawai = DB::table('pegawai')->get();
        return view('admin.absensi.tambah', ['pegawai' => $pegawai]);
    }

    // ================= Simpan Absensi Baru =================
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'status_masuk' => 'nullable|in:hadir,sakit,izin,alfa,cuti',
            'keterangan_masuk' => 'nullable|string',
            'foto_masuk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoMasuk = null;

        if ($request->hasFile('foto_masuk')) {
            $fotoMasuk = $request->file('foto_masuk')->store('foto_absensi_masuk', 'public');
        }

        DB::table('absensi')->insert([
            'id_pegawai' => $request->id_pegawai,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'status_masuk' => $request->status_masuk,
            'keterangan_masuk' => $request->keterangan_masuk,
            'foto_masuk' => $fotoMasuk,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/absensi')->with("success", "Data Absensi Berhasil Ditambah !");
    }

    // ================= Edit Absensi =================
    public function edit($id)
    {
        $absensi = DB::table('absensi')->where('id', $id)->first();
        $pegawai = DB::table('pegawai')->get();

        return view('admin.absensi.edit', [
            'absensi' => $absensi,
            'pegawai' => $pegawai
        ]);
    }

    // ================= Update Absensi =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'status_masuk' => 'nullable|in:hadir,sakit,izin,alfa,cuti',
            'keterangan_masuk' => 'nullable|string',
            'foto_masuk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $absensi = DB::table('absensi')->where('id', $id)->first();

        $data = [
            'id_pegawai' => $request->id_pegawai,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'status_masuk' => $request->status_masuk,
            'keterangan_masuk' => $request->keterangan_masuk,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto_masuk')) {
            if ($absensi->foto_masuk) {
                Storage::disk('public')->delete($absensi->foto_masuk);
            }

            $data['foto_masuk'] = $request->file('foto_masuk')->store('foto_absensi_masuk', 'public');
        }

        DB::table('absensi')->where('id', $id)->update($data);

        return redirect('/admin/absensi')->with("success", "Data Absensi Berhasil Diupdate !");
    }

    // ================= Hapus Absensi =================
    public function delete($id)
    {
        $absensi = DB::table('absensi')->where('id', $id)->first();

        if ($absensi && $absensi->foto_masuk) {
            Storage::disk('public')->delete($absensi->foto_masuk);
        }

        DB::table('absensi')->where('id', $id)->delete();

        return redirect('/admin/absensi')->with("success", "Data Absensi Berhasil Dihapus !");
    }
}
