@extends('admin.layout')

@section('title', 'Detail Penugasan Satgas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Penugasan Satgas</h6>
            <div>
                <a href="{{ route('admin.kasus_satgas.edit', [$kasusSatgas->id_kasus, $kasusSatgas->id_satgas]) }}" 
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.kasus_satgas.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-left-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-primary mb-4">Informasi Kasus</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Kode Pengaduan</th>
                                    <td>{{ $kasusSatgas->kasus->no_pengaduan }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Masalah</th>
                                    <td>{{ ucfirst($kasusSatgas->kasus->jenis_masalah) }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pengaduan</th>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $kasusSatgas->kasus->status_pengaduan === 'selesai' ? 'success' : 
                                            ($kasusSatgas->kasus->status_pengaduan === 'proses satgas' ? 'primary' : 'warning') 
                                        }}">
                                            {{ ucfirst($kasusSatgas->kasus->status_pengaduan) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $kasusSatgas->kasus->deskripsi_kasus }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-left-success h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-success mb-4">Informasi Satgas</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Nama Satgas</th>
                                    <td>{{ $kasusSatgas->satgas->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <a href="mailto:{{ $kasusSatgas->satgas->email }}">
                                            {{ $kasusSatgas->satgas->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>No. WhatsApp</th>
                                    <td>
                                        <a href="https://wa.me/{{ $kasusSatgas->satgas->no_wa }}" target="_blank">
                                            {{ $kasusSatgas->satgas->no_wa }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card border-left-info">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-info mb-4">Detail Penugasan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Tanggal Tindak Lanjut</th>
                                    <td>{{ \Carbon\Carbon::parse($kasusSatgas->tanggal_tindak_lanjut)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>
                                        {{ $kasusSatgas->tanggal_tindak_selesai ? 
                                           \Carbon\Carbon::parse($kasusSatgas->tanggal_tindak_selesai)->format('d F Y') : 
                                           '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $kasusSatgas->status_tindak_lanjut === 'selesai' ? 'success' : 'primary' }}">
                                            {{ ucfirst($kasusSatgas->status_tindak_lanjut) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 