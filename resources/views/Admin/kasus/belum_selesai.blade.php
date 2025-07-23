@extends('admin.layout')

@section('title', 'Kasus Belum Selesai')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kasus Belum Selesai</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kasus Belum Selesai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No Pengaduan</th>
                            <th>Pelapor</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasus as $k)
                        <tr>
                            <td>{{ $k->no_pengaduan }}</td>
                            <td>{{ $k->pelapor->nama_lengkap }}</td>
                            <td>{{ $k->judul_pengaduan }}</td>
                            <td>
                                {{ $k->lokasi_fasilitas }}
                                <div class="small text-muted">{{ $k->jenis_fasilitas }}</div>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $k->status === 'Menunggu' ? 'warning' : 'info'
                                }}">
                                    {{ $k->status }}
                                </span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($k->tanggal_pengaduan)->format('d/m/Y') }}
                                @if($k->tanggal_penanganan)
                                    <div class="small text-muted">
                                        Penanganan: {{ \Carbon\Carbon::parse($k->tanggal_penanganan)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kasus.show', $k->id) }}" 
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kasus.edit', $k->id) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[5, 'desc']], // Sort by tanggal column descending
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection 