@extends('admin.layout')

@section('title', 'Detail Pelapor')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pelapor</h1>
        <div>
            <a href="{{ route('admin.pelapor.edit', $pelapor->id_pelapor) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.pelapor.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Pelapor</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td>{{ $pelapor->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Nama Panggilan</th>
                            <td>{{ $pelapor->nama_panggilan }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-{{ $pelapor->status_pelapor == 'staff' ? 'primary' : 'info' }}">
                                    {{ ucfirst($pelapor->status_pelapor) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <a href="mailto:{{ $pelapor->email }}">{{ $pelapor->email }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>No. WhatsApp</th>
                            <td>
                                <a href="https://wa.me/{{ $pelapor->no_wa }}" target="_blank">
                                    {{ $pelapor->no_wa }}
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 