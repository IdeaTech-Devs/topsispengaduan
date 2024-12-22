@extends('admin.layout')

@section('title', 'Edit Admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Admin</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.management.update', $admin->id_admin) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nama">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" value="{{ old('nama', $admin->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                           id="telepon" name="telepon" value="{{ old('telepon', $admin->telepon) }}" required>
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto_profil">Foto Profil</label>
                    @if($admin->foto_profil)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$admin->foto_profil) }}" 
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
                    <a href="{{ route('admin.management.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 