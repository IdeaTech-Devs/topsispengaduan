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
                                <p class="mb-2">Anda berada di Dashboard Admin Sistem Pengaduan Mahasiswa. Berikut adalah beberapa informasi penting:</p>
                                <ul class="mb-3">
                                    <li>Terdapat {{ $kasusBelumSelesaiCount }} kasus yang membutuhkan perhatian Anda</li>
                                    <li>Total {{ $semuaKasusCount }} kasus telah dilaporkan dalam sistem</li>
                                    <li>{{ $totalSatgas }} Satgas dan {{ $totalKemahasiswaan }} Staff Kemahasiswaan aktif dalam sistem</li>
                                </ul>
                                <div class="mt-3">
                                    <h6 class="font-weight-bold text-primary mb-2">Akses Cepat Data Master:</h6>
                                    <div class="btn-group flex-wrap">
                                        <a href="{{ route('admin.satgas.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-user-shield fa-fw mr-1"></i>Satgas
                                        </a>
                                        <a href="{{ route('admin.kemahasiswaan.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-users fa-fw mr-1"></i>Kemahasiswaan
                                        </a>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-user fa-fw mr-1"></i>Users
                                        </a>
                                        <a href="{{ route('admin.pelapor.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-user-edit fa-fw mr-1"></i>Pelapor
                                        </a>
                                        <a href="{{ route('admin.kasus.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-folder fa-fw mr-1"></i>Kasus
                                        </a>
                                        <a href="{{ route('admin.kasus_satgas.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-tasks fa-fw mr-1"></i>Kasus Satgas
                                        </a>
                                        <a href="{{ route('admin.management.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-user-shield fa-fw mr-1"></i>Kelola Admin
                                        </a>
                                        <a href="{{ route('admin.topsis.index') }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-calculator fa-fw mr-1"></i>Kriteria TOPSIS
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-university fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Semua Kasus -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Semua Kasus</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $semuaKasusCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kasus Belum Selesai -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kasus Belum Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusBelumSelesaiCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kasus Selesai -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Kasus Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusSelesaiCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Satgas -->
        <div class="col-xl-2 col-md-6 mb-4">
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

        <!-- Total Kemahasiswaan -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Kemahasiswaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKemahasiswaan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
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
                                    <th>Kode Pengaduan</th>
                                    <th>Nama Pelapor</th>
                                    <th>Jenis Masalah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kasusTerbaru as $kasus)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kasus->kode_pengaduan }}</td>
                                    <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                                    <td>{{ $kasus->jenis_masalah }}</td>
                                    <td>{{ ucfirst($kasus->status_pengaduan) }}</td>
                                    <td>{{ $kasus->created_at->format('d M Y') }}</td>
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