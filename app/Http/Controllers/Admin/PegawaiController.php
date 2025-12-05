<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ================= List Semua Pegawai =================
    public function index()
    {
        // Join ke users untuk ambil nama user
        $pegawai = DB::table('pegawai')
            ->join('users', 'pegawai.id_user', '=', 'users.id')
            ->select('pegawai.*', 'users.name as user_name') // hapus users.email
            ->orderBy('pegawai.id', 'DESC')
            ->get();

        return view('admin.pegawai.index', ['pegawai' => $pegawai]);
    }

    // ================= Form Tambah Pegawai =================
    public function create()
    {
        $users = DB::table('users')->get();
        return view('admin.pegawai.tambah', ['users' => $users]);
    }

    // ================= Simpan Data Pegawai Baru =================
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'nip'     => 'required|unique:pegawai,nip',
            'nama'    => 'required|string|max:255',
            'contact' => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto_pegawai', 'public');
        }

        DB::table('pegawai')->insert([
            'id_user'    => $request->id_user,
            'nip'        => $request->nip,
            'nama'       => $request->nama,
            'contact'    => $request->contact,
            'alamat'     => $request->alamat,
            'foto'       => $foto,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/pegawai')->with("success", "Data Pegawai Berhasil Ditambah !");
    }

    // ================= Form Edit Pegawai =================
    public function edit($id)
    {
        $pegawai = DB::table('pegawai')->where('id', $id)->first();
        $users = DB::table('users')->get();

        return view('admin.pegawai.edit', [
            'pegawai' => $pegawai,
            'users'   => $users
        ]);
    }

    // ================= Update Data Pegawai =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'nip'     => 'required|unique:pegawai,nip,' . $id,
            'nama'    => 'required|string|max:255',
            'contact' => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pegawai = DB::table('pegawai')->where('id', $id)->first();

        $data = [
            'id_user'    => $request->id_user,
            'nip'        => $request->nip,
            'nama'       => $request->nama,
            'contact'    => $request->contact,
            'alamat'     => $request->alamat,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_pegawai', 'public');
        }

        DB::table('pegawai')->where('id', $id)->update($data);

        return redirect('/admin/pegawai')->with("success", "Data Pegawai Berhasil Diupdate !");
    }

    // ================= Hapus Pegawai =================
    public function delete($id)
    {
        $pegawai = DB::table('pegawai')->where('id', $id)->first();
        if ($pegawai && $pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        DB::table('pegawai')->where('id', $id)->delete();

        return redirect('/admin/pegawai')->with("success", "Data Pegawai Berhasil Dihapus !");
    }
}
