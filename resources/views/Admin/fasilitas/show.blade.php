@extends('admin.layout')

@section('title', 'Detail Fasilitas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Fasilitas</h1>
        <div>
            <a href="{{ route('admin.fasilitas.edit', $fasilitas->id_fasilitas) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Fasilitas</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">Kode Fasilitas</th>
                            <td>{{ $fasilitas->kode_fasilitas }}</td>
                        </tr>
                        <tr>
                            <th>Nama Fasilitas</th>
                            <td>{{ $fasilitas->nama_fasilitas }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ $fasilitas->jenis_fasilitas }}</td>
                        </tr>
                        <tr>
                            <th>Ruang</th>
                            <td>
                                {{ $fasilitas->ruang->nama_ruang }}
                                <div class="small text-muted">{{ $fasilitas->ruang->lokasi }}</div>
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $fasilitas->deskripsi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 