@extends('admin.layouts.app', [
'activePage' => 'jenis_kendaraan',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-12 col-sm-12">
            <div class="title">
               <h4>Data Jenis Kendaraan</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item"><a href="/admin/jenis_kendaraan">Data Jenis Kendaraan</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Jenis Kendaraan</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Jenis Kendaraan</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/jenis_kendaraan" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
      <form action="/admin/jenis_kendaraan/create" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}

         <!-- Dropdown Jenis Kendaraan -->
         <div class="form-group">
            <label>Jenis Kendaraan<span class="text-danger">*</span></label>
            <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control select2" required>
               <option value="">-- Pilih Jenis Kendaraan --</option>
               <option value="Roda 2">Roda 2</option>
               <option value="Roda 4">Roda 4</option>
               <option value="Roda 6">Roda 6</option>
            </select>
         </div>

         <!-- Input Tarif (otomatis terisi) -->
         <div class="form-group">
            <label>Tarif<span class="text-danger">*</span></label>
            <input type="text" id="tarif" name="tarif" class="form-control" readonly required>
         </div>

         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Tambah Data</button>
      </form>
   </div>
   <!-- Striped table End -->
</div>

{{-- Script untuk otomatisasi tarif --}}
<script>
   document.getElementById('jenis_kendaraan').addEventListener('change', function () {
      let tarifInput = document.getElementById('tarif');
      let value = this.value;

      if (value === 'Roda 2') {
         tarifInput.value = 2000;
      } else if (value === 'Roda 4') {
         tarifInput.value = 4000;
      } else if (value === 'Roda 6') {
         tarifInput.value = 6000;
      } else {
         tarifInput.value = '';
      }
   });
</script>
@endsection
