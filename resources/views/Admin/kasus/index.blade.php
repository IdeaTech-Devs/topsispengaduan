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
                            <td>{{ $k->no_pengaduan }}</td>
                            <td>{{ $k->pelapor->nama_lengkap ?? '-' }}</td>
                            <td>{{ $k->jenis_fasilitas ?? '-' }}</td>
                            <td>
                                @php
                                    $urgensi = strtolower($k->tingkat_urgensi);
                                    $badge = $urgensi === 'tinggi' ? 'danger' : ($urgensi === 'sedang' ? 'warning' : 'success');
                                @endphp
                                <span class="badge badge-{{ $badge }}">
                                    {{ ucfirst($urgensi) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    // Mapping warna badge untuk status
                                    $status = strtolower($k->status);
                                    $badgeStatus = [
                                        'menunggu' => 'secondary',    // Abu-abu
                                        'diproses' => 'primary',      // Biru
                                        'ditolak' => 'danger',        // Merah
                                        'selesai' => 'success',       // Hijau
                                        'dikonfirmasi' => 'info',     // Biru muda
                                    ];
                                    $badge = $badgeStatus[$status] ?? 'dark';
                                @endphp
                                <span class="badge badge-{{ $badge }}">
                                    {{ ucfirst($k->status) }}
                                </span>
                            </td>
                            <td>{{ $k->tanggal_pengaduan ? $k->tanggal_pengaduan->format('d-m-Y H:i') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kasus.show', $k->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kasus.edit', $k->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kasus.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kasus ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
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
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection 