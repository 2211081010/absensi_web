@extends('admin.layouts.app', [
'activePage' => 'petugas',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-12 col-sm-12">
            <div class="title">
               <h4>Data Petugas</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item"><a href="/admin/petugas">Data Petugas</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Petugas</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Petugas</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/petugas" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">

      @if ($errors->any())
         <div class="alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif

      <form action="/admin/petugas/create" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}

         <div class="form-group">
            <label>Nama Petugas <span class="text-danger">*</span></label>
            <input type="text" name="nama" required class="form-control" placeholder="Masukkan Nama Petugas...">
         </div>

         <div class="form-group">
            <label>No HP <span class="text-danger">*</span></label>
            <input type="text" name="nohp" required class="form-control" placeholder="Masukkan No HP...">
         </div>

         <div class="form-group">
            <label>Kantor <span class="text-danger">*</span></label>
            <select name="id_kantor" class="form-control">
               <option value="">-- Pilih Kantor --</option>
               @foreach($kantor as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kantor }}</option>
               @endforeach
            </select>
         </div>

         <div class="form-group">
            <label>Foto <span class="text-danger">*</span></label><br>
            <input type="file" name="foto" required>
         </div>

         <button type="submit" class="btn btn-primary mt-1 mr-2">
            <span class="icon-copy ti-save"></span> Tambah Data
         </button>
      </form>
   </div>
   <!-- Striped table End -->
</div>
@endsection
