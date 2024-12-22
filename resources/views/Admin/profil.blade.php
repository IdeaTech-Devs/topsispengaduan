@extends('admin.layout')

@section('title', 'Profil Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow mb-4 profile-card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Profil Admin</h6>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.update-profil') }}" 
                      enctype="multipart/form-data" 
                      onsubmit="return validateProfileForm()" 
                      class="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        <div class="profile-image-container">
                            <img src="{{ $admin->foto_profil ? asset('storage/'.$admin->foto_profil) : asset('assets/img/undraw_profile.svg') }}" 
                                class="img-profile rounded-circle" 
                                id="preview">
                            <div class="camera-icon" onclick="document.getElementById('foto_profil').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <input type="file" name="foto_profil" id="foto_profil" 
                               class="d-none" accept="image/*" onchange="previewProfileImage()">
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $admin->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ $admin->email }}" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                               value="{{ old('telepon', $admin->telepon) }}" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save fa-sm fa-fw mr-2"></i>Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#resetPasswordModal">
                            <i class="fas fa-key fa-sm fa-fw mr-2"></i>Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.update-password') }}" onsubmit="return validatePasswordForm()">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" 
                               required minlength="8">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               required minlength="8">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save fa-sm fa-fw mr-2"></i>Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
