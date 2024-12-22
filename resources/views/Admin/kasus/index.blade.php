@extends('admin.layout')

@section('title', 'Data Kasus')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kasus</h1>
        <a href="{{ route('admin.kasus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kasus
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kasus</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pelapor</th>
                            <th>Jenis Masalah</th>
                            <th>Urgensi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasus as $k)
                        <tr>
                            <td>{{ $k->kode_pengaduan }}</td>
                            <td>
                                {{ $k->pelapor->nama_lengkap }}
                                <div class="small text-muted">{{ $k->asal_fakultas }}</div>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $k->jenis_masalah === 'kekerasan seksual' ? 'danger' : 
                                    ($k->jenis_masalah === 'bullying' ? 'warning' : 
                                    ($k->jenis_masalah === 'pelecehan verbal' ? 'info' : 
                                    ($k->jenis_masalah === 'diskriminasi' ? 'dark' : 
                                    ($k->jenis_masalah === 'cyberbullying' ? 'primary' : 'secondary')))) 
                                }}">
                                    {{ ucfirst($k->jenis_masalah) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $k->urgensi === 'segera' ? 'danger' : 
                                    ($k->urgensi === 'dalam beberapa hari' ? 'warning' : 'info') 
                                }}">
                                    {{ ucfirst($k->urgensi) }}
                                </span>
                                <div class="small text-muted">
                                    Dampak: {{ ucfirst($k->dampak) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $k->status_pengaduan === 'perlu dikonfirmasi' ? 'warning' : 
                                    ($k->status_pengaduan === 'dikonfirmasi' ? 'info' : 
                                    ($k->status_pengaduan === 'ditolak' ? 'danger' : 
                                    ($k->status_pengaduan === 'proses satgas' ? 'primary' : 'success'))) 
                                }}">
                                    {{ ucfirst($k->status_pengaduan) }}
                                </span>
                                @if($k->kemahasiswaan)
                                    <div class="small text-muted">
                                        {{ $k->kemahasiswaan->nama }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($k->tanggal_pengaduan)->format('d/m/Y') }}
                                @if($k->tanggal_konfirmasi)
                                    <div class="small text-muted">
                                        Konfirmasi: {{ \Carbon\Carbon::parse($k->tanggal_konfirmasi)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kasus.show', $k->id_kasus) }}" 
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kasus.edit', $k->id_kasus) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kasus.destroy', $k->id_kasus) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kasus ini?');">
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
            order: [[5, 'desc']], // Sort by tanggal column descending
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection 