@extends('admin.layout')

@section('title', 'Data Kemahasiswaan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kemahasiswaan</h1>
        <a href="{{ route('admin.kemahasiswaan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kemahasiswaan
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kemahasiswaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Fakultas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kemahasiswaan as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <img src="{{ $k->foto_profil ? asset('storage/'.$k->foto_profil) : asset('assets/img/undraw_profile.svg') }}" 
                                     alt="Foto Profil" 
                                     class="rounded-circle"
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->email }}</td>
                            <td>{{ $k->telepon }}</td>
                            <td>{{ $k->fakultas }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kemahasiswaan.show', $k->id_kemahasiswaan) }}" 
                                       class="btn btn-info btn-sm" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kemahasiswaan.edit', $k->id_kemahasiswaan) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kemahasiswaan.destroy', $k->id_kemahasiswaan) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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