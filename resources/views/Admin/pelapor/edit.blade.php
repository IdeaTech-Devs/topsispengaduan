@extends('admin.layout')

@section('title', 'Edit Pelapor')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pelapor</h1>
        <a href="{{ route('admin.pelapor.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Pelapor</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pelapor.update', $pelapor->id_pelapor) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" 
                                   name="nama_lengkap" 
                                   class="form-control @error('nama_lengkap') is-invalid @enderror"
                                   value="{{ old('nama_lengkap', $pelapor->nama_lengkap) }}"
                                   required>
                            @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Panggilan</label>
                            <input type="text" 
                                   name="nama_panggilan" 
                                   class="form-control @error('nama_panggilan') is-invalid @enderror"
                                   value="{{ old('nama_panggilan', $pelapor->nama_panggilan) }}"
                                   required>
                            @error('nama_panggilan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status_pelapor" 
                                    class="form-control @error('status_pelapor') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="staff" {{ old('status_pelapor', $pelapor->status_pelapor) == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="pengunjung" {{ old('status_pelapor', $pelapor->status_pelapor) == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                            </select>
                            @error('status_pelapor')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $pelapor->email) }}"
                                   required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>No. WhatsApp</label>
                            <input type="text" 
                                   name="no_wa" 
                                   class="form-control @error('no_wa') is-invalid @enderror"
                                   value="{{ old('no_wa', $pelapor->no_wa) }}"
                                   required>
                            @error('no_wa')
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