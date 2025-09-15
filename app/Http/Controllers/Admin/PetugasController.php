<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampil semua petugas
    public function read()
    {
        $petugas = DB::table('petugas')
            ->leftJoin('kantor', 'petugas.id_kantor', '=', 'kantor.id')
            ->select('petugas.*', 'kantor.nama_kantor')
            ->orderBy('petugas.id', 'DESC')
            ->get();

        return view('admin.petugas.index', ['petugas' => $petugas]);
    }

    // Form tambah
    public function add()
    {
        $kantor = DB::table('kantor')->get();
        return view('admin.petugas.tambah', ['kantor' => $kantor]);
    }

    // Simpan data baru
    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'id_kantor' => 'nullable|exists:kantor,id',
        ]);

        $path = $request->file('foto')->store('foto_petugas', 'public');

        DB::table('petugas')->insert([
            'id_kantor' => $request->id_kantor,
            'nama'      => $request->nama,
            'nohp'      => $request->nohp,
            'foto'      => $path,
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        return redirect('/admin/petugas')->with("success", "Data Berhasil Ditambah !");
    }

    // Form edit
    public function edit($id)
    {
        $petugas = DB::table('petugas')->where('id', $id)->first();
        $kantor = DB::table('kantor')->get();
        return view('admin.petugas.edit', [
            'petugas' => $petugas,
            'kantor' => $kantor
        ]);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_kantor' => 'nullable|exists:kantor,id',
        ]);

        $data = [
            'id_kantor' => $request->id_kantor,
            'nama'      => $request->nama,
            'nohp'      => $request->nohp,
            'updated_at'=> now(),
        ];

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_petugas', 'public');
            $data['foto'] = $path;
        }

        DB::table('petugas')->where('id', $id)->update($data);

        return redirect('/admin/petugas')->with("success", "Data Berhasil Diupdate !");
    }

    // Hapus data
    public function delete($id)
    {
        $petugas = DB::table('petugas')->where('id', $id)->first();
        if ($petugas && $petugas->foto) {
            Storage::disk('public')->delete($petugas->foto);
        }

        DB::table('petugas')->where('id', $id)->delete();
        return redirect('/admin/petugas')->with("success", "Data Berhasil Dihapus !");
    }
}
