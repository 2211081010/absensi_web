@extends('admin.layouts.app', ['activePage' => 'absensi'])

@section('content')
<div class="min-height-200px">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h4>Data Absensi</h4>
            </div>
        </div>
    </div>

    <div class="pd-20 card-box mb-30">
        <div class="clearfix mb-3">
            <div class="pull-left">
                <h2 class="h4 text-primary"><i class="dw dw-calendar"></i> List Absensi</h2>
            </div>
            <div class="pull-right">
                <a href="/admin/absensi/add" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped table-bordered data-table">
            <thead class="bg-primary text-white">
                <tr>
                    <th>#</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Tanggal</th>

                    <th>Jam Masuk</th>
                    <th>Status Masuk</th>
                    <th>Keterangan Masuk</th>
                    <th>Foto Masuk</th>

                    <th>Jam Pulang</th>
                    <th>Status Pulang</th>
                    <th>Keterangan Pulang</th>
                    <th>Foto Pulang</th>

                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @php $no = 1; @endphp
                @foreach($absensi as $a)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $a->nip }}</td>
                    <td>{{ $a->nama_pegawai }}</td>
                    <td>{{ $a->tanggal }}</td>

                    <td>{{ $a->jam_masuk ?? '-' }}</td>
                    <td>{{ $a->status_masuk ?? '-' }}</td>
                    <td>{{ $a->keterangan_masuk ?? '-' }}</td>
                    <td>
                        @if($a->foto_masuk)
                            <img src="{{ asset('storage/'.$a->foto_masuk) }}" width="50" class="rounded">
                        @else - @endif
                    </td>

                    <td>{{ $a->jam_pulang ?? '-' }}</td>
                    <td>{{ $a->status_pulang ?? '-' }}</td>
                    <td>{{ $a->keterangan_pulang ?? '-' }}</td>
                    <td>
                        @if($a->foto_pulang)
                            <img src="{{ asset('storage/'.$a->foto_pulang) }}" width="50" class="rounded">
                        @else - @endif
                    </td>

                    <td class="text-center">
                        <a href="/admin/absensi/edit/{{ $a->id }}" class="btn btn-success btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $a->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DELETE --}}
@foreach($absensi as $a)
<div class="modal fade" id="delete-{{ $a->id }}">
   <div class="modal-dialog">
      <div class="modal-content p-3">
         <h4>Hapus Data?</h4>
         <p>Absensi Pegawai <b>{{ $a->nama_pegawai }}</b> tanggal <b>{{ $a->tanggal }}</b></p>

         <div class="text-right mt-4">
            <a href="/admin/absensi/delete/{{ $a->id }}" class="btn btn-primary">Ya</a>
            <button class="btn btn-danger" data-dismiss="modal">Tidak</button>
         </div>
      </div>
   </div>
</div>
@endforeach

@endsection
