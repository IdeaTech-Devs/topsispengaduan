@extends('admin.layout')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Fasilitas</h1>
        <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Fasilitas</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.fasilitas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ruang</label>
                            <select name="ruang_id" 
                                    class="form-control @error('ruang_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Ruang --</option>
                                @foreach($ruang as $r)
                                <option value="{{ $r->id_ruang }}" 
                                        {{ old('ruang_id') == $r->id_ruang ? 'selected' : '' }}>
                                    {{ $r->nama_ruang }} ({{ $r->lokasi }})
                                </option>
                                @endforeach
                            </select>
                            @error('ruang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Fasilitas</label>
                            <input type="text" 
                                   name="nama_fasilitas" 
                                   class="form-control @error('nama_fasilitas') is-invalid @enderror"
                                   value="{{ old('nama_fasilitas') }}"
                                   required>
                            @error('nama_fasilitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Fasilitas</label>
                            <select name="jenis_fasilitas" 
                                    class="form-control @error('jenis_fasilitas') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Jenis Fasilitas --</option>
                                @foreach($jenisFasilitas as $jenis)
                                <option value="{{ $jenis }}" 
                                        {{ old('jenis_fasilitas') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_fasilitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kode Fasilitas</label>
                            <input type="text" 
                                   name="kode_fasilitas" 
                                   class="form-control @error('kode_fasilitas') is-invalid @enderror"
                                   value="{{ old('kode_fasilitas') }}"
                                   required>
                            @error('kode_fasilitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 