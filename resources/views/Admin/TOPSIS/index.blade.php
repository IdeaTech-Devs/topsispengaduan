@extends('admin.layout')

@section('title', 'Kelola Kriteria TOPSIS')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Kriteria TOPSIS</h1>
        <a href="{{ route('admin.topsis.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kriteria
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kriteria</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                            <th>Jenis</th>
                            <th>Nilai Kriteria</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kriteria }}</td>
                            <td>{{ $k->bobot }}</td>
                            <td>
                                <span class="badge badge-{{ $k->jenis === 'benefit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($k->jenis) }}
                                </span>
                            </td>
                            <td>
                                @if($k->nilaiKriteria->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($k->nilaiKriteria as $nilai)
                                            <li>{{ $nilai->item }}: {{ $nilai->nilai }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Belum ada nilai</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.topsis.edit', $k->id_kriteria) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.topsis.destroy', $k->id_kriteria) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?');">
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
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection 