@extends('admin.layout')

@section('title', 'Data Kasus Satgas')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kasus Satgas</h1>
        <a href="{{ route('admin.kasus_satgas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Penugasan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Penugasan Satgas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Pengaduan</th>
                            <th>Nama Satgas</th>
                            <th>Tanggal Tindak Lanjut</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasusSatgas as $ks)
                        <tr>
                            <td>{{ $ks->kasus->kode_pengaduan }}</td>
                            <td>{{ $ks->satgas->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($ks->tanggal_tindak_lanjut)->format('d/m/Y') }}</td>
                            <td>
                                {{ $ks->tanggal_tindak_selesai ? \Carbon\Carbon::parse($ks->tanggal_tindak_selesai)->format('d/m/Y') : '-' }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $ks->status_tindak_lanjut === 'selesai' ? 'success' : 'primary' }}">
                                    {{ ucfirst($ks->status_tindak_lanjut) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kasus_satgas.show', [$ks->id_kasus, $ks->id_satgas]) }}" 
                                       class="btn btn-info btn-sm" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kasus_satgas.edit', [$ks->id_kasus, $ks->id_satgas]) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kasus_satgas.destroy', [$ks->id_kasus, $ks->id_satgas]) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus penugasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[2, 'desc']], // Sort by tanggal_tindak_lanjut column descending
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection 