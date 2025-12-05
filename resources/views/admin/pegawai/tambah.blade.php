@extends('admin.layouts.app', [
'activePage' => 'pegawai',
])
@section('content')
<div class="min-height-200px">

   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Tambah Pegawai</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item"><a href="/admin/pegawai">Data Pegawai</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>

   <div class="pd-20 card-box mb-30">

      {{-- Tampilkan Error --}}
      @if ($errors->any())
         <div class="alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif

      <form action="/admin/pegawai/store" method="POST" enctype="multipart/form-data">
         @csrf

         {{-- Pilih User --}}
         <div class="form-group">
            <label for="id_user">User</label>
            <select class="form-control" name="id_user" id="id_user" required>
               <option value="">-- Pilih User --</option>
               @foreach($users as $user)
                  <option value="{{ $user->id }}">
                     {{ $user->name }}
                  </option>
               @endforeach
            </select>
         </div>

         {{-- NIP --}}
         <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" name="nip" id="nip"
                   placeholder="Masukkan NIP" required value="{{ old('nip') }}">
         </div>

         {{-- Nama Pegawai --}}
         <div class="form-group">
            <label for="nama">Nama Pegawai</label>
            <input type="text" class="form-control" name="nama" id="nama"
                   placeholder="Masukkan Nama Pegawai" required value="{{ old('nama') }}">
         </div>

         {{-- Contact --}}
         <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" class="form-control" name="contact" id="contact"
                   placeholder="Masukkan Contact (Opsional)" value="{{ old('contact') }}">
         </div>

         {{-- Alamat --}}
         <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat"
                      rows="3" placeholder="Masukkan Alamat (Opsional)">{{ old('alamat') }}</textarea>
         </div>

         {{-- Foto --}}
         <div class="form-group">
            <label for="foto">Foto Pegawai</label>
            <input type="file" class="form-control-file" name="foto" id="foto" accept="image/*">
         </div>

         {{-- Tombol --}}
         <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="/admin/pegawai" class="btn btn-danger"><i class="fa fa-times"></i> Batal</a>
         </div>

      </form>
   </div>
</div>
@endsection
