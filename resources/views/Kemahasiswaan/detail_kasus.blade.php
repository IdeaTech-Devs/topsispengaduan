@extends('kemahasiswaan.layout')

@section('title', 'Detail Kasus')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kasus</h1>
        <button onclick="window.history.back()" class="btn btn-secondary btn-download">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
    </div>

    <div class="row">
        <!-- Data Pelapor -->
        <div class="col-lg-6">
            <div class="card shadow mb-4 detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-light">Data Pelapor</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless detail-table">
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
                        </tr>>
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
                            <td>Hubungan dengan Korban</td>
                            <td>:</td>
                            <td>{{ ucfirst($kasus->pelapor->hubungan_korban) ?? '-' }}</td>
                        </tr>
                    </table>

                    <div class="mt-4 detail-attachment">
                        <div class="detail-attachment-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div>
                            <div class="detail-label">Bukti Identitas:</div>
                            <a href="{{ asset('storage/'.$kasus->pelapor->bukti_identitas) }}" 
                               target="_blank" 
                               class="btn btn-info btn-sm btn-download">
                                <i class="fas fa-file-download"></i> Unduh Bukti Identitas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Kasus -->
        <div class="col-lg-6">
            <div class="card shadow mb-4 detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-light">Data Kasus</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless detail-table">
                        <tr>
                            <td width="35%">Kode Pengaduan</td>
                            <td width="5%">:</td>
                            <td>{{ $kasus->kode_pengaduan }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Masalah</td>
                            <td>:</td>
                            <td>{{ ucfirst($kasus->jenis_masalah) }}</td>
                        </tr>
                        <tr>
                            <td>Urgensi</td>
                            <td>:</td>
                            <td>{{ ucfirst($kasus->urgensi) }}</td>
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

                    <div class="detail-description">
                        <h6 class="font-weight-bold detail-label">Deskripsi Kasus:</h6>
                        <p class="text-justify detail-value">{{ $kasus->deskripsi_kasus }}</p>
                    </div>

                    @if($kasus->bukti_kasus)
                    <div class="detail-attachment">
                        <div class="detail-attachment-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <div class="detail-label">Bukti Kasus:</div>
                            <a href="{{ asset('storage/'.$kasus->bukti_kasus) }}" 
                               target="_blank" 
                               class="btn btn-info btn-sm btn-download">
                                <i class="fas fa-file-download"></i> Unduh Bukti
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Evaluasi -->
    @if(!$kasus->id_kemahasiswaan)
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 detail-card">
                <div class="card-body text-center">
                    <button type="button" class="btn btn-primary btn-lg btn-download" data-toggle="modal" data-target="#evaluasiModal">
                        <i class="fas fa-check-circle"></i> Evaluasi Kasus
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal Evaluasi -->
<div class="modal fade" id="evaluasiModal" tabindex="-1" role="dialog" aria-labelledby="evaluasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluasiModalLabel">Konfirmasi Evaluasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kemahasiswaan.evaluasi_kasus', $kasus->id_kasus) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengevaluasi kasus ini?</p>
                    <p>Kasus ini akan masuk ke daftar kelola kasus Anda.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Evaluasi Kasus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
