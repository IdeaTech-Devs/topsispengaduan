@extends('satgas.layout')

@section('title', 'Detail Kasus')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kasus</h1>
        <div>
            @if($kasus->status != 'Selesai')
                <button class="btn btn-success" data-toggle="modal" data-target="#selesaiModal">
                    <i class="fas fa-check"></i> Selesai
                </button>
            @endif
            <a href="{{ route('satgas.kasus_proses') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Data Pelapor -->
        <div class="col-lg-6">
            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Data Pelapor</h6>
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
                            <td>Status</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-{{ $kasus->pelapor->status_pelapor == 'staff' ? 'primary' : 'info' }}">
                                    {{ ucfirst($kasus->pelapor->status_pelapor) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td>:</td>
                            <td>
                                <a href="mailto:{{ $kasus->pelapor->email }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-envelope"></i> Email
                                </a>
                                <a href="https://wa.me/{{ $kasus->pelapor->no_wa }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Kasus -->
        <div class="col-lg-6">
            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Data Kasus</h6>
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
                                    $kasus->status == 'Selesai' ? 'success' : 
                                    ($kasus->status == 'Diproses' ? 'info' : 'warning') 
                                }}">
                                    {{ ucfirst($kasus->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Judul Pengaduan</td>
                            <td>:</td>
                            <td>{{ $kasus->judul_pengaduan }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Fasilitas</td>
                            <td>:</td>
                            <td>{{ ucfirst($kasus->jenis_fasilitas) }}</td>
                        </tr>
                        <tr>
                            <td>Lokasi Fasilitas</td>
                            <td>:</td>
                            <td>{{ $kasus->lokasi_fasilitas }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengaduan</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td>Tingkat Urgensi</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-{{ 
                                    $kasus->tingkat_urgensi === 'Tinggi' ? 'danger' : 
                                    ($kasus->tingkat_urgensi === 'Sedang' ? 'warning' : 'info') 
                                }}">
                                    {{ $kasus->tingkat_urgensi }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <h6 class="font-weight-bold">Deskripsi Kasus:</h6>
                        <p class="text-justify">{{ $kasus->deskripsi }}</p>
                    </div>

                    @if($kasus->catatan_satgas)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Catatan Penanganan:</h6>
                            <p class="text-justify">{{ $kasus->catatan_satgas }}</p>
                        </div>
                    @endif

                    @if($kasus->foto_bukti)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Bukti Kasus:</h6>
                            <a href="{{ asset('storage/'.$kasus->foto_bukti) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-file-download"></i> Unduh Bukti
                            </a>
                        </div>
                    @endif

                    @if($kasus->foto_penanganan)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Foto Penanganan:</h6>
                            <a href="{{ asset('storage/'.$kasus->foto_penanganan) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-file-download"></i> Unduh Foto Penanganan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Selesai -->
<div class="modal fade" id="selesaiModal" tabindex="-1" role="dialog" aria-labelledby="selesaiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('satgas.update_status_kasus', $kasus->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status_tindak_lanjut" value="selesai">
                <div class="modal-header">
                    <h5 class="modal-title" id="selesaiModalLabel">Selesaikan Kasus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="penangan_kasus">Penangan Kasus</label>
                        <input type="text" class="form-control" name="penangan_kasus" 
                               value="{{ $pimpinan->nama }}" required>
                    </div>
                    <div class="form-group">
                        <label for="catatan_penanganan">Catatan Penanganan</label>
                        <textarea class="form-control" name="catatan_penanganan" 
                                  rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Selesaikan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
