@extends('admin.layout')

@section('title', 'Edit Ruang')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Ruang</h1>
        <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Ruang</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ruang.update', $ruang->id_ruang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Ruang</label>
                            <input type="text" 
                                   name="nama_ruang" 
                                   class="form-control @error('nama_ruang') is-invalid @enderror"
                                   value="{{ old('nama_ruang', $ruang->nama_ruang) }}"
                                   required>
                            @error('nama_ruang')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" 
                                   name="lokasi" 
                                   class="form-control @error('lokasi') is-invalid @enderror"
                                   value="{{ old('lokasi', $ruang->lokasi) }}"
                                   required>
                            @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kode Ruang</label>
                            <input type="text" 
                                   name="kode_ruang" 
                                   class="form-control @error('kode_ruang') is-invalid @enderror"
                                   value="{{ old('kode_ruang', $ruang->kode_ruang) }}"
                                   required>
                            @error('kode_ruang')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 