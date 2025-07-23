@extends('admin.layout')

@section('title', 'Detail Kasus')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kasus</h1>
        <div>
            @if($kasus->status_pengaduan == 'selesai')
                <button class="btn btn-warning" data-toggle="modal" data-target="#prosesUlangModal">
                    <i class="fas fa-redo"></i> Proses Ulang
                </button>
            @else
                <button class="btn btn-success" data-toggle="modal" data-target="#selesaiModal">
                    <i class="fas fa-check"></i> Selesai
                </button>
            @endif
            <a href="{{ route('admin.tindak_lanjut.belum_selesai') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Data Pelapor -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pelapor</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="35%">Nama Lengkap</td>
                            <td width="5%">:</td>
                            <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td>Nama Panggilan</td>
                            <td>:</td>
                            <td>{{ $kasus->pelapor->nama_panggilan }}</td>
                        </tr>
                        <tr>
                            <td>Unsur</td>
                            <td>:</td>
                            <td>{{ ucfirst($kasus->pelapor->unsur) }}</td>
                        </tr>
                        <tr>
                            <td>Departemen/Prodi</td>
                            <td>:</td>
                            <td>{{ $kasus->pelapor->departemen_prodi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Unit Kerja</td>
                            <td>:</td>
                            <td>{{ $kasus->pelapor->unit_kerja ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td>:</td>
                            <td>
                                <a href="mailto:{{ $kasus->pelapor->email }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-envelope"></i> Email
                                </a>
                                <a href="https://wa.me/{{ $kasus->pelapor->no_hp }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <h6 class="font-weight-bold">Bukti Identitas:</h6>
                        <a href="{{ asset('storage/'.$kasus->pelapor->bukti_identitas) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-file-download"></i> Unduh Bukti Identitas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Kasus -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Kasus</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="35%">Kode Pengaduan</td>
                            <td width="5%">:</td>
                            <td>{{ $kasus->no_pengaduan }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-{{ 
                                    $kasus->status_pengaduan == 'selesai' ? 'success' : 
                                    ($kasus->status_pengaduan == 'proses satgas' ? 'info' : 'warning') 
                                }}">
                                    {{ ucfirst($kasus->status_pengaduan) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Masalah</td>
                            <td>:</td>
                            <td>{{ ucfirst($kasus->jenis_masalah) }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengaduan</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td>Asal Fakultas</td>
                            <td>:</td>
                            <td>{{ $kasus->asal_fakultas }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <h6 class="font-weight-bold">Deskripsi Kasus:</h6>
                        <p class="text-justify">{{ $kasus->deskripsi_kasus }}</p>
                    </div>

                    @if($kasus->catatan_penanganan)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Catatan Penanganan:</h6>
                            <p class="text-justify">{{ $kasus->catatan_penanganan }}</p>
                        </div>
                    @endif

                    @if($kasus->bukti_kasus)
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Bukti Kasus:</h6>
                        <a href="{{ asset('storage/'.$kasus->bukti_kasus) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-file-download"></i> Unduh Bukti
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Petugas yang Menangani -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Petugas yang Menangani</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Kemahasiswaan:</h6>
                        <p>{{ $kasus->kemahasiswaan->nama }}</p>
                        <a href="mailto:{{ $kasus->kemahasiswaan->email }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                        <a href="https://wa.me/{{ $kasus->kemahasiswaan->telepon }}" class="btn btn-sm btn-success" target="_blank">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>

                    <div>
                        <h6 class="font-weight-bold">Satgas:</h6>
                        @foreach($kasus->satgas as $satgas)
                            <div class="mb-3">
                                <p>{{ $satgas->nama }}</p>
                                <a href="mailto:{{ $satgas->email }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-envelope"></i> Email
                                </a>
                                <a href="https://wa.me/{{ $satgas->telepon }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Selesai dan Proses Ulang tetap sama seperti sebelumnya -->
@endsection
