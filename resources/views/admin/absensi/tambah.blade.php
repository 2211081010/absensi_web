@extends('admin.layouts.app', ['activePage' => 'absensi'])
@section('content')

<div class="pd-20 card-box mb-30">

<h4 class="text-primary">Tambah Data Absensi</h4>
<hr>

<form action="/admin/absensi/create" method="POST" enctype="multipart/form-data">
@csrf

{{-- Pegawai --}}
<div class="form-group">
    <label>Pegawai</label>
    <select name="id_pegawai" class="form-control" required>
        <option value="">-- Pilih Pegawai --</option>
        @foreach($pegawai as $p)
            <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->nip }})</option>
        @endforeach
    </select>
</div>

{{-- Tanggal --}}
<div class="form-group">
    <label>Tanggal</label>
    <input type="date" name="tanggal" class="form-control" required>
</div>

<hr><h5>Absensi Masuk</h5>

<div class="row">
    <div class="col-md-4">
        <label>Jam Masuk</label>
        <input type="time" name="jam_masuk" class="form-control">
    </div>

    <div class="col-md-4">
        <label>Status Masuk</label>
        <select name="status_masuk" class="form-control">
            <option value="">-</option>
            <option value="hadir">Hadir</option>
            <option value="sakit">Sakit</option>
            <option value="izin">Izin</option>
            <option value="alfa">Alfa</option>
            <option value="cuti">Cuti</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>Foto Masuk</label>
        <input type="file" name="foto_masuk" class="form-control">
    </div>
</div>

<div class="form-group mt-3">
    <label>Keterangan Masuk</label>
    <textarea name="keterangan_masuk" class="form-control"></textarea>
</div>

<hr><h5>Absensi Pulang</h5>

<div class="row">
    <div class="col-md-4">
        <label>Jam Pulang</label>
        <input type="time" name="jam_pulang" class="form-control">
    </div>

    <div class="col-md-4">
        <label>Status Pulang</label>
        <select name="status_pulang" class="form-control">
            <option value="">-</option>
            <option value="hadir">Hadir</option>
            <option value="sakit">Sakit</option>
            <option value="izin">Izin</option>
            <option value="alfa">Alfa</option>
            <option value="cuti">Cuti</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>Foto Pulang</label>
        <input type="file" name="foto_pulang" class="form-control">
    </div>
</div>

<div class="form-group mt-3">
    <label>Keterangan Pulang</label>
    <textarea name="keterangan_pulang" class="form-control"></textarea>
</div>

<button class="btn btn-primary btn-block">Simpan</button>

</form>

</div>
@endsection
