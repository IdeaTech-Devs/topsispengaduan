@extends('admin.layout')

@section('title', 'Detail Satgas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Satgas</h1>
        <div>
            <a href="{{ route('admin.satgas.edit', $satgas->id_satgas) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.satgas.index') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Satgas</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ $satgas->foto_profil ? asset('storage/'.$satgas->foto_profil) : asset('assets/img/undraw_profile.svg') }}" 
                             alt="Foto Profil" 
                             class="img-profile rounded-circle"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <td width="35%">Nama Lengkap</td>
                            <td width="5%">:</td>
                            <td>{{ $satgas->nama }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>
                                {{ $satgas->email }}
                                <a href="mailto:{{ $satgas->email }}" class="btn btn-sm btn-primary ml-2">
                                    <i class="fas fa-envelope"></i> Kirim Email
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor Telepon</td>
                            <td>:</td>
                            <td>
                                {{ $satgas->telepon }}
                                <a href="https://wa.me/{{ $satgas->telepon }}" class="btn btn-sm btn-success ml-2" target="_blank">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Bergabung Sejak</td>
                            <td>:</td>
                            <td>{{ $satgas->created_at->format('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Penanganan Kasus</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Kasus Ditangani</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $satgas->kasus->count() }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Kasus Aktif</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $kasusAktif->count() }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="font-weight-bold">Kasus yang Sedang Ditangani:</h6>
                        @if($kasusAktif->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kode Pengaduan</th>
                                            <th>Jenis Masalah</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kasusAktif as $kasus)
                                        <tr>
                                            <td>{{ $kasus->kode_pengaduan }}</td>
                                            <td>{{ $kasus->jenis_masalah }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ ucfirst($kasus->status_pengaduan) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.tindak_lanjut.detail', $kasus->id_kasus) }}" 
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Tidak ada kasus yang sedang ditangani.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 