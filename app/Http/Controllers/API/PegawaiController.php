<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    // 🔹 Ambil data pegawai berdasarkan user login
    public function byUser(Request $request)
    {
        $userId = $request->user()->id;

        $pegawai = DB::table('pegawai')->where('id_user', $userId)->first();

        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan'], 404);
        }

        // Tambahkan URL foto agar bisa ditampilkan di Flutter / Frontend
        $pegawai = (array) $pegawai;
        if (!empty($pegawai['foto'])) {
            $pegawai['foto_url'] = asset('storage/foto_pegawai/' . $pegawai['foto']);
        } else {
            $pegawai['foto_url'] = asset('storage/foto_pegawai/default_user.jpg');
        }

        return response()->json([
            'message' => 'Data pegawai berhasil diambil',
            'data' => $pegawai
        ], 200);
    }

    // 🔹 Update data profil pegawai + password (opsional)
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'contact' => 'required|string',
            'alamat' => 'required|string',
            'old_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed', // gunakan password_confirmation
        ]);

        $userId = $request->user()->id;

        $pegawai = DB::table('pegawai')->where('id_user', $userId)->first();
        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan'], 404);
        }

        // Update profil pegawai
        DB::table('pegawai')->where('id_user', $userId)->update([
            'nama' => $request->nama,
            'contact' => $request->contact,
            'alamat' => $request->alamat
        ]);

        // Update password jika diisi
        if ($request->filled('old_password') && $request->filled('password')) {
            $user = $request->user();

            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama salah'
                ], 400);
            }

            DB::table('users')->where('id', $userId)->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui'
        ], 200);
    }

    // 🔹 Update foto pegawai
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $userId = $request->user()->id;

        $pegawai = DB::table('pegawai')->where('id_user', $userId)->first();
        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan'], 404);
        }

        // Jika sudah ada foto lama → hapus
        if ($pegawai->foto) {
            Storage::disk('public')->delete('foto_pegawai/' . $pegawai->foto);
        }

        // Simpan foto baru
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/foto_pegawai', $filename);

        // Update database
        DB::table('pegawai')->where('id_user', $userId)->update([
            'foto' => $filename
        ]);

        return response()->json([
            'message' => 'Foto profil berhasil diperbarui',
            'foto_url' => asset('storage/foto_pegawai/' . $filename)
        ], 200);
    }
}
