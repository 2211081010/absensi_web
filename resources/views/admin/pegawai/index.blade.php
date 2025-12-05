@extends('admin.layouts.app', [
'activePage' => 'pegawai',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Data Pegawai</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-user"></i> List Data Pegawai</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/pegawai/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</a>
         </div>
      </div>
      <hr style="margin-top: 0px;">
      @if (session('error'))
      <div class="alert alert-danger">
         {{ session('error') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
      @if (session('success'))
      <div class="alert alert-success">
         {{ session('success') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
      <table class="table table-striped table-bordered data-table hover">
         <thead class="bg-primary text-white">
            <tr>
               <th width="5%">#</th>
               <th>NIP</th>
               <th>Nama</th>
               <th>Contact</th>
               <th>Alamat</th>
               <th>Foto</th>
               <th class="table-plus datatable-nosort text-center">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php $no = 1; ?>
            @foreach($pegawai as $data)
            <tr>
               <td class="text-center">{{$no++}}</td>
               <td>{{$data->nip}}</td>
               <td>{{$data->nama}}</td>
               <td>{{$data->contact ?? '-'}}</td>
               <td>{{$data->alamat ?? '-'}}</td>
               <td class="text-center">
                  @if($data->foto)
                     <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto" width="50" height="50" class="rounded-circle">
                  @else
                     -
                  @endif
               </td>
               <td class="text-center" width="15%">
                  <a href="/admin/pegawai/edit/{{$data->id}}">
                     <button class="btn btn-success btn-xs"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Data"></i></button>
                  </a>
                  <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-{{$data->id}}">
                     <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Data"></i>
                  </button>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
   <!-- Striped table End -->
</div>

<!-- Modal Delete -->
@foreach($pegawai as $data)
<div class="modal fade" id="delete-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <h2 class="text-center">Apakah Anda Yakin Menghapus Data Ini ?</h2>
            <hr>
            <div class="form-group" style="font-size: 17px;">
               <label>Nama Pegawai</label>
               <input class="form-control" value="{{$data->nama}}" readonly style="background-color: white;pointer-events: none;">
            </div>
            <div class="row mt-4">
               <div class="col-md-6">
                  <a href="/admin/pegawai/delete/{{$data->id}}" style="text-decoration: none;">
                     <button type="button" class="btn btn-primary btn-block">Ya</button>
                  </a>
               </div>
               <div class="col-md-6">
                  <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" aria-label="Close">Tidak</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endforeach
@endsection
