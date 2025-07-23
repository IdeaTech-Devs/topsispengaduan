@extends('admin.layout')

@section('title', 'Detail Ruang')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Ruang</h1>
        <div>
            <a href="{{ route('admin.ruang.edit', $ruang->id_ruang) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Ruang</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">Kode Ruang</th>
                            <td>{{ $ruang->kode_ruang }}</td>
                        </tr>
                        <tr>
                            <th>Nama Ruang</th>
                            <td>{{ $ruang->nama_ruang }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $ruang->lokasi }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($ruang->fasilitas->count() > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Daftar Fasilitas</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Fasilitas</th>
                                    <th>Jenis</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ruang->fasilitas as $fasilitas)
                                <tr>
                                    <td>{{ $fasilitas->kode_fasilitas }}</td>
                                    <td>{{ $fasilitas->nama_fasilitas }}</td>
                                    <td>{{ $fasilitas->jenis_fasilitas }}</td>
                                    <td>{{ $fasilitas->deskripsi ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection 