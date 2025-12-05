public function today($id)
{
    $absen = DB::table('absensi')
        ->where('id_pegawai', $id)
        ->where('tanggal', date('Y-m-d'))
        ->first();

    if (!$absen) {
        return response()->json([
            'status' => 'belum',
            'jam_masuk' => null,
            'jam_pulang' => null
        ]);
    }

    if ($absen->jam_masuk && !$absen->jam_pulang) {
        return response()->json([
            'status' => 'masuk',
            'jam_masuk' => $absen->jam_masuk,
            'jam_pulang' => null
        ]);
    }

    return response()->json([
        'status' => 'pulang',
        'jam_masuk' => $absen->jam_masuk,
        'jam_pulang' => $absen->jam_pulang
    ]);
}
