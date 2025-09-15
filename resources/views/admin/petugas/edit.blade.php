@extends('admin.layouts.app', [
    'activePage' => 'petugas',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Data Petugas</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item"><a href="/admin/petugas">Data Petugas</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Data Petugas</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>

   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-edit-1"></i> Edit Data Petugas</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/petugas" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">

      <form action="/admin/petugas/update/{{$petugas->id}}" method="POST" enctype="multipart/form-data">
         @csrf

         {{-- Pilih Kantor --}}
         <div class="form-group">
            <label>Kantor<span class="text-danger">*</span></label>
            <select name="id_kantor" class="form-control" required>
               <option value="">-- Pilih Kantor --</option>
               @foreach($kantor as $k)
                  <option value="{{ $k->id }}" {{ $petugas->id_kantor == $k->id ? 'selected' : '' }}>
                     {{ $k->nama_kantor }}
                  </option>
               @endforeach
            </select>
         </div>

         {{-- Nama Petugas --}}
         <div class="form-group">
            <label>Nama Petugas<span class="text-danger">*</span></label>
            <input type="text" name="nama" required class="form-control"
                   value="{{ $petugas->nama }}" placeholder="Masukkan Nama Petugas .....">
         </div>

         {{-- Nomor HP --}}
         <div class="form-group">
            <label>No HP<span class="text-danger">*</span></label>
            <input type="text" name="nohp" required class="form-control"
                   value="{{ $petugas->nohp }}" placeholder="Masukkan Nomor HP .....">
         </div>

         {{-- Foto --}}
         <div class="form-group">
            <label>Foto<span class="text-danger">*</span></label><br>
            @if($petugas->foto)
               <img src="{{ asset('uploads/petugas/'.$petugas->foto) }}" width="120" class="mb-2"><br>
            @endif
            <input type="file" name="foto" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
         </div>

         <button type="submit" class="btn btn-primary mt-1 mr-2">
            <span class="icon-copy ti-save"></span> Update Data
         </button>
      </form>
   </div>
   <!-- Striped table End -->
</div>
@endsection
