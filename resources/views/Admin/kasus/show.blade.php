@extends('admin.layout')

@section('title', 'Detail Kasus')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kasus</h1>
        <div>
            <a href="{{ route('admin.kasus.edit', $kasus->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.kasus.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Kasus</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">No Pengaduan</th>
                            <td>{{ $kasus->no_pengaduan }}</td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Judul</th>
                            <td>{{ $kasus->judul_pengaduan }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $kasus->lokasi_fasilitas }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Fasilitas</th>
                            <td>{{ $kasus->jenis_fasilitas }}</td>
                        </tr>
                        <tr>
                            <th>Tingkat Urgensi</th>
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
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">Status</th>
                            <td>
                                <span class="badge badge-{{ 
                                    $kasus->status === 'Menunggu' ? 'warning' : 
                                    ($kasus->status === 'Diproses' ? 'info' : 
                                    ($kasus->status === 'Ditolak' ? 'danger' : 'success')) 
                                }}">
                                    {{ $kasus->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengaduan</th>
                            <td>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d/m/Y') }}</td>
                        </tr>
                        @if($kasus->tanggal_penanganan)
                        <tr>
                            <th>Tanggal Penanganan</th>
                            <td>{{ \Carbon\Carbon::parse($kasus->tanggal_penanganan)->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        @if($kasus->tanggal_selesai)
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>{{ \Carbon\Carbon::parse($kasus->tanggal_selesai)->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Deskripsi</h5>
                    <p>{{ $kasus->deskripsi }}</p>
                </div>
            </div>

            @if($kasus->foto_bukti)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Foto Bukti</h5>
                    <img src="{{ asset('storage/'.$kasus->foto_bukti) }}" alt="Foto Bukti" class="img-fluid" style="max-width: 300px">
                </div>
            </div>
            @endif

            @if($kasus->foto_penanganan)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Foto Penanganan</h5>
                    <img src="{{ asset('storage/'.$kasus->foto_penanganan) }}" alt="Foto Penanganan" class="img-fluid" style="max-width: 300px">
                </div>
            </div>
            @endif

            @if($kasus->catatan_admin)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Catatan Admin</h5>
                    <p>{{ $kasus->catatan_admin }}</p>
                </div>
            </div>
            @endif

            @if($kasus->catatan_satgas)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Catatan Satgas</h5>
                    <p>{{ $kasus->catatan_satgas }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 