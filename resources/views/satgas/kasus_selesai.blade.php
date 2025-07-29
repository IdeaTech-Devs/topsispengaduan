@extends('satgas.layout')

@section('title', 'Kasus Selesai')

@section('content')
<div class="container-fluid">
    <!-- Informasi Jumlah Kasus Selesai dalam bentuk Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Kasus yang Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusSelesai->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Kasus -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if($kasusSelesai->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada kasus yang selesai ditangani.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Pengaduan</th>
                                <th>Judul Pengaduan</th>
                                <th>Jenis Fasilitas</th>
                                <th>Pelapor</th>
                                <th>Tanggal Pengaduan</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasusSelesai as $kasus)
                                <tr>
                                    <td>{{ $kasus->no_pengaduan }}</td>
                                    <td>{{ $kasus->judul_pengaduan }}</td>
                                    <td>{{ ucfirst($kasus->jenis_fasilitas) }}</td>
                                    <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                                    <td>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                    <td>{{ $kasus->tanggal_selesai ? \Carbon\Carbon::parse($kasus->tanggal_selesai)->format('d F Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('satgas.detail_kasus', $kasus->id) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $kasusSelesai->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td {
        vertical-align: middle;
    }
</style>
@endpush 