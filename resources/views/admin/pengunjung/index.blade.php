@extends('admin.layouts.app', ['activePage' => 'pengunjung'])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Data Pengunjung</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Pengunjung</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-list"></i> List Data Pengunjung</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/pengunjung/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</a>
         </div>
      </div>
      <hr style="margin-top: 0px;">
      @if (session('error'))
      <div class="alert alert-danger">
         {{ session('error')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
      @if (session('success'))
      <div class="alert alert-success">
         {{ session('success')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
   <table class="table table-striped table-bordered">
      <thead class="bg-primary text-white">
         <tr>
            <th>#</th>
            <th>Nama Member</th>
            <th>Metode Pembayaran</th>
            <th>Lokasi</th>
            <th>Petugas</th>
            <th>Jenis Kendaraan</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>NoPol</th>
            <th>Bukti Pembayaran</th>
            <th>Status</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         @foreach($pengunjung as $no => $data)
         <tr>
            <td>{{ $no+1 }}</td>
            <td>{{ $data->nama_member }}</td>
            <td>{{ $data->nama_metode }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->nama_petugas }}</td>
            <td>{{ $data->jenis_kendaraan }}</td>
            <td>{{ $data->tanggal }}</td>
            <td>{{ $data->jam_masuk }}</td>
            <td>{{ $data->jam_keluar }}</td>
            <td>{{ $data->nopol }}</td>
            <td>
                @if($data->bukti_pembayaran)
                    <a href="{{ asset('storage/'.$data->bukti_pembayaran) }}" target="_blank">Lihat</a>
                @endif
            </td>
            <td>{{ $data->status }}</td>
            <td>
                <a href="/admin/pengunjung/edit/{{$data->id}}" class="btn btn-success btn-xs">Edit</a>
                <a href="/admin/pengunjung/delete/{{$data->id}}" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-xs">Hapus</a>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
@endsection
