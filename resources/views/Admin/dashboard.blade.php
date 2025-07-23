@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-2 font-weight-bold text-primary">Selamat Datang, {{ $nama_admin }}!</div>
                            <div class="text-gray-800">
                                <p class="mb-2">Anda berada di Dashboard Admin Sistem Pengaduan Fasilitas. Berikut adalah beberapa informasi penting:</p>
                                <ul class="mb-3">
                                    <li>Terdapat {{ $kasusBelumSelesai }} kasus yang membutuhkan perhatian Anda</li>
                                    <li>Total {{ $totalKasus }} kasus telah dilaporkan dalam sistem</li>
                                    <li>{{ $totalSatgas }} Satgas aktif dalam sistem</li>
                                </ul>
                                <div class="mt-3">
                                    <h6 class="font-weight-bold text-primary mb-2">Akses Cepat Data Master:</h6>
                                    <div class="btn-group flex-wrap">
                                        <a href="{{ route('admin.satgas.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-user-shield fa-fw mr-1"></i>Satgas
                                        </a>
                                        <a href="{{ route('admin.pelapor.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-user-edit fa-fw mr-1"></i>Pelapor
                                        </a>
                                        <a href="{{ route('admin.kasus.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-folder fa-fw mr-1"></i>Kasus
                                        </a>
                                        <a href="{{ route('admin.ruang.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-building fa-fw mr-1"></i>Ruang
                                        </a>
                                        <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-tools fa-fw mr-1"></i>Fasilitas
                                        </a>
                                        <a href="{{ route('admin.topsis.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-calculator fa-fw mr-1"></i>Kriteria TOPSIS
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Semua Kasus -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Semua Kasus</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKasus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kasus Belum Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kasus Belum Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusBelumSelesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kasus Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kasus Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusSelesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Satgas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Satgas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSatgas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Tabel Data Terbaru -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kasus Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pengaduan</th>
                                    <th>Nama Pelapor</th>
                                    <th>Judul</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kasusTerbaru as $kasus)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kasus->no_pengaduan }}</td>
                                    <td>{{ $kasus->pelapor->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $kasus->judul_pengaduan }}</td>
                                    <td>
                                        {{ $kasus->lokasi_fasilitas }}
                                        <div class="small text-muted">{{ $kasus->jenis_fasilitas }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $kasus->status === 'Menunggu' ? 'warning' : 
                                            ($kasus->status === 'Diproses' ? 'info' : 
                                            ($kasus->status === 'Ditolak' ? 'danger' : 'success')) 
                                        }}">
                                            {{ $kasus->status }}
                                        </span>
                                    </td>
                                    <td>{{ $kasus->tanggal_pengaduan ? \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d M Y') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection