@extends('admin.layout')

@section('title', 'Detail Kemahasiswaan')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data Kemahasiswaan</h6>
            <div>
                <a href="{{ route('admin.kemahasiswaan.edit', $kemahasiswaan->id_kemahasiswaan) }}" 
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.kemahasiswaan.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <img src="{{ $kemahasiswaan->foto_profil ? asset('storage/'.$kemahasiswaan->foto_profil) : asset('assets/img/undraw_profile.svg') }}" 
                         alt="Foto Profil" 
                         class="img-fluid rounded-circle mb-3"
                         style="width: 200px; height: 200px; object-fit: cover;">
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama</th>
                            <td>{{ $kemahasiswaan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                {{ $kemahasiswaan->email }}
                                <a href="mailto:{{ $kemahasiswaan->email }}" class="btn btn-sm btn-primary ml-2">
                                    <i class="fas fa-envelope"></i> Kirim Email
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>
                                {{ $kemahasiswaan->telepon }}
                                <a href="https://wa.me/{{ $kemahasiswaan->telepon }}" class="btn btn-sm btn-success ml-2" target="_blank">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Fakultas</th>
                            <td>{{ $kemahasiswaan->fakultas }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Statistik Kasus -->
            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="font-weight-bold text-primary">Statistik Penanganan Kasus</h6>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Kasus</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $kemahasiswaan->kasus->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-folder fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Kasus Dalam Proses</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $kemahasiswaan->kasus->whereIn('status_pengaduan', ['perlu dikonfirmasi', 'dikonfirmasi', 'proses satgas'])->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Kasus Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $kemahasiswaan->kasus->where('status_pengaduan', 'selesai')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Kasus Ditolak</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $kemahasiswaan->kasus->where('status_pengaduan', 'ditolak')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Kasus Aktif -->
            <div class="mt-4">
                <h6 class="font-weight-bold text-primary">Kasus yang Sedang Ditangani</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Pengaduan</th>
                                <th>Tanggal</th>
                                <th>Jenis Masalah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kemahasiswaan->kasus->whereIn('status_pengaduan', ['perlu dikonfirmasi', 'dikonfirmasi', 'proses satgas']) as $kasus)
                            <tr>
                                <td>{{ $kasus->kode_pengaduan }}</td>
                                <td>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($kasus->jenis_masalah) }}</td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $kasus->status_pengaduan == 'perlu dikonfirmasi' ? 'warning' : 
                                        ($kasus->status_pengaduan == 'dikonfirmasi' ? 'info' : 'primary') 
                                    }}">
                                        {{ ucfirst($kasus->status_pengaduan) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.kasus.show', $kasus->id_kasus) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada kasus yang sedang ditangani</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 