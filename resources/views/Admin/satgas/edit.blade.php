@extends('admin.layout')

@section('title', 'Edit Satgas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Pimpinan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.satgas.update', $satgas->id_satgas) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" value="{{ old('nama', $satgas->nama) }}" required maxlength="100">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $satgas->email) }}" required maxlength="100">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telepon">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                   id="telepon" name="telepon" value="{{ old('telepon', $satgas->telepon) }}" required maxlength="15">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto_profil">Foto Profil</label>
                            @if($satgas->foto_profil)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$satgas->foto_profil) }}"
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
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.satgas.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
