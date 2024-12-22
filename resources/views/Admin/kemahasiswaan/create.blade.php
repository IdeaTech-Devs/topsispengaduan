@extends('admin.layout')

@section('title', 'Tambah Kemahasiswaan')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Kemahasiswaan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kemahasiswaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="nama">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                           id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fakultas">Fakultas <span class="text-danger">*</span></label>
                    <select class="form-control @error('fakultas') is-invalid @enderror" 
                            id="fakultas" name="fakultas" required>
                        <option value="">Pilih Fakultas</option>
                        <option value="Teknik" {{ old('fakultas') == 'Teknik' ? 'selected' : '' }}>Teknik</option>
                        <option value="Hukum" {{ old('fakultas') == 'Hukum' ? 'selected' : '' }}>Hukum</option>
                        <option value="Pertanian" {{ old('fakultas') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Ilmu Sosial dan Ilmu Politik" {{ old('fakultas') == 'Ilmu Sosial dan Ilmu Politik' ? 'selected' : '' }}>Ilmu Sosial dan Ilmu Politik</option>
                        <option value="Keguruan dan Ilmu Pendidikan" {{ old('fakultas') == 'Keguruan dan Ilmu Pendidikan' ? 'selected' : '' }}>Keguruan dan Ilmu Pendidikan</option>
                        <option value="Ekonomi dan Bisnis" {{ old('fakultas') == 'Ekonomi dan Bisnis' ? 'selected' : '' }}>Ekonomi dan Bisnis</option>
                        <option value="Kedokteran dan Ilmu Kesehatan" {{ old('fakultas') == 'Kedokteran dan Ilmu Kesehatan' ? 'selected' : '' }}>Kedokteran dan Ilmu Kesehatan</option>
                        <option value="Matematika dan Ilmu Pengetahuan Alam" {{ old('fakultas') == 'Matematika dan Ilmu Pengetahuan Alam' ? 'selected' : '' }}>Matematika dan Ilmu Pengetahuan Alam</option>
                    </select>
                    @error('fakultas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto_profil">Foto Profil</label>
                    <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" 
                           id="foto_profil" name="foto_profil">
                    @error('foto_profil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.kemahasiswaan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 