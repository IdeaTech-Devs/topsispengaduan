@extends('admin.layout')

@section('title', 'Edit Kemahasiswaan')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Kemahasiswaan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kemahasiswaan.update', $kemahasiswaan->id_kemahasiswaan) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nama">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" 
                           value="{{ old('nama', $kemahasiswaan->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" 
                           value="{{ old('email', $kemahasiswaan->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                           id="telepon" name="telepon" 
                           value="{{ old('telepon', $kemahasiswaan->telepon) }}" required>
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fakultas">Fakultas <span class="text-danger">*</span></label>
                    <select class="form-control @error('fakultas') is-invalid @enderror" 
                            id="fakultas" name="fakultas" required>
                        <option value="">Pilih Fakultas</option>
                        <option value="Teknik" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Teknik' ? 'selected' : '' }}>Teknik</option>
                        <option value="Hukum" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Hukum' ? 'selected' : '' }}>Hukum</option>
                        <option value="Pertanian" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Ilmu Sosial dan Ilmu Politik" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Ilmu Sosial dan Ilmu Politik' ? 'selected' : '' }}>Ilmu Sosial dan Ilmu Politik</option>
                        <option value="Keguruan dan Ilmu Pendidikan" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Keguruan dan Ilmu Pendidikan' ? 'selected' : '' }}>Keguruan dan Ilmu Pendidikan</option>
                        <option value="Ekonomi dan Bisnis" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Ekonomi dan Bisnis' ? 'selected' : '' }}>Ekonomi dan Bisnis</option>
                        <option value="Kedokteran dan Ilmu Kesehatan" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Kedokteran dan Ilmu Kesehatan' ? 'selected' : '' }}>Kedokteran dan Ilmu Kesehatan</option>
                        <option value="Matematika dan Ilmu Pengetahuan Alam" {{ old('fakultas', $kemahasiswaan->fakultas) == 'Matematika dan Ilmu Pengetahuan Alam' ? 'selected' : '' }}>Matematika dan Ilmu Pengetahuan Alam</option>
                    </select>
                    @error('fakultas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto_profil">Foto Profil</label>
                    @if($kemahasiswaan->foto_profil)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$kemahasiswaan->foto_profil) }}" 
                                 alt="Foto Profil" 
                                 class="img-thumbnail"
                                 style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" 
                           id="foto_profil" name="foto_profil">
                    @error('foto_profil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.
                    </small>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.kemahasiswaan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 