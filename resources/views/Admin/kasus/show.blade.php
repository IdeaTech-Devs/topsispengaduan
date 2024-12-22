@extends('admin.layout')

@section('title', 'Detail Kasus')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Kasus</h6>
            <div>
                <a href="{{ route('admin.kasus.edit', $kasus->id_kasus) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.kasus.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-left-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-primary mb-4">Informasi Kasus</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Kode Pengaduan</th>
                                    <td>{{ $kasus->kode_pengaduan }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Masalah</th>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $kasus->jenis_masalah === 'kekerasan seksual' ? 'danger' : 
                                            ($kasus->jenis_masalah === 'bullying' ? 'warning' : 
                                            ($kasus->jenis_masalah === 'pelecehan verbal' ? 'info' : 
                                            ($kasus->jenis_masalah === 'diskriminasi' ? 'dark' : 
                                            ($kasus->jenis_masalah === 'cyberbullying' ? 'primary' : 'secondary')))) 
                                        }}">
                                            {{ ucfirst($kasus->jenis_masalah) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Pengaduan</th>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $kasus->status_pengaduan === 'perlu dikonfirmasi' ? 'warning' : 
                                            ($kasus->status_pengaduan === 'dikonfirmasi' ? 'info' : 
                                            ($kasus->status_pengaduan === 'ditolak' ? 'danger' : 
                                            ($kasus->status_pengaduan === 'proses satgas' ? 'primary' : 'success'))) 
                                        }}">
                                            {{ ucfirst($kasus->status_pengaduan) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Urgensi</th>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $kasus->urgensi === 'segera' ? 'danger' : 
                                            ($kasus->urgensi === 'dalam beberapa hari' ? 'warning' : 'info') 
                                        }}">
                                            {{ ucfirst($kasus->urgensi) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dampak</th>
                                    <td>{{ ucfirst($kasus->dampak) }}</td>
                                </tr>
                                <tr>
                                    <th>Asal Fakultas</th>
                                    <td>{{ $kasus->asal_fakultas }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-left-success h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-success mb-4">Informasi Pelapor</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Nama Lengkap</th>
                                    <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <a href="mailto:{{ $kasus->pelapor->email }}">
                                            {{ $kasus->pelapor->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>No. WhatsApp</th>
                                    <td>
                                        <a href="https://wa.me/{{ $kasus->pelapor->no_wa }}" target="_blank">
                                            {{ $kasus->pelapor->no_wa }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Unsur</th>
                                    <td>{{ ucfirst($kasus->pelapor->unsur) }}</td>
                                </tr>
                                <tr>
                                    <th>Hubungan dengan Korban</th>
                                    <td>{{ $kasus->pelapor->hubungan_korban ? ucfirst($kasus->pelapor->hubungan_korban) : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-left-info">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-info mb-4">Detail Penanganan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Tanggal Pengaduan</th>
                                    <td>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Konfirmasi</th>
                                    <td>{{ $kasus->tanggal_konfirmasi ? \Carbon\Carbon::parse($kasus->tanggal_konfirmasi)->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kemahasiswaan</th>
                                    <td>{{ $kasus->kemahasiswaan ? $kasus->kemahasiswaan->nama : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Bukti Kasus</th>
                                    <td>
                                        @if($kasus->bukti_kasus)
                                            <a href="{{ Storage::url($kasus->bukti_kasus) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-file"></i> Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada bukti</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Deskripsi Kasus</th>
                                    <td>{{ $kasus->deskripsi_kasus }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan Penanganan</th>
                                    <td>{{ $kasus->catatan_penanganan ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if($kasus->status_pengaduan === 'proses satgas' || $kasus->status_pengaduan === 'selesai')
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-left-warning">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-warning mb-4">Penugasan Satgas</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Satgas</th>
                                            <th>Tanggal Tindak Lanjut</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kasus->kasusSatgas as $ks)
                                        <tr>
                                            <td>{{ $ks->satgas->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($ks->tanggal_tindak_lanjut)->format('d F Y') }}</td>
                                            <td>{{ $ks->tanggal_tindak_selesai ? \Carbon\Carbon::parse($ks->tanggal_tindak_selesai)->format('d F Y') : '-' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $ks->status_tindak_lanjut === 'selesai' ? 'success' : 'primary' }}">
                                                    {{ ucfirst($ks->status_tindak_lanjut) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada penugasan satgas</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 