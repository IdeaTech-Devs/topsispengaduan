@extends('admin.layout')

@section('title', 'Edit Pelapor')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Pelapor</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pelapor.update', $pelapor->id_pelapor) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   id="nama_lengkap" name="nama_lengkap" 
                                   value="{{ old('nama_lengkap', $pelapor->nama_lengkap) }}" 
                                   required maxlength="100">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_panggilan">Nama Panggilan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_panggilan') is-invalid @enderror" 
                                   id="nama_panggilan" name="nama_panggilan" 
                                   value="{{ old('nama_panggilan', $pelapor->nama_panggilan) }}" 
                                   required maxlength="50">
                            @error('nama_panggilan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unsur">Unsur <span class="text-danger">*</span></label>
                            <select class="form-control @error('unsur') is-invalid @enderror" 
                                    id="unsur" name="unsur" required>
                                <option value="">Pilih Unsur</option>
                                <option value="dosen" {{ old('unsur', $pelapor->unsur) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="mahasiswa" {{ old('unsur', $pelapor->unsur) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="tenaga kependidikan" {{ old('unsur', $pelapor->unsur) == 'tenaga kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                                <option value="lainnya" {{ old('unsur', $pelapor->unsur) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('unsur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="melapor_sebagai">Melapor Sebagai <span class="text-danger">*</span></label>
                            <select class="form-control @error('melapor_sebagai') is-invalid @enderror" 
                                    id="melapor_sebagai" name="melapor_sebagai" required>
                                <option value="">Pilih Status Pelaporan</option>
                                <option value="korban" {{ old('melapor_sebagai', $pelapor->melapor_sebagai) == 'korban' ? 'selected' : '' }}>Korban</option>
                                <option value="saksi" {{ old('melapor_sebagai', $pelapor->melapor_sebagai) == 'saksi' ? 'selected' : '' }}>Saksi</option>
                                <option value="pihak lain" {{ old('melapor_sebagai', $pelapor->melapor_sebagai) == 'pihak lain' ? 'selected' : '' }}>Pihak Lain</option>
                            </select>
                            @error('melapor_sebagai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bukti_identitas">Bukti Identitas</label>
                            @if($pelapor->bukti_identitas)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($pelapor->bukti_identitas) }}" target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-file"></i> Lihat File Saat Ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('bukti_identitas') is-invalid @enderror" 
                                   id="bukti_identitas" name="bukti_identitas">
                            @error('bukti_identitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Format: JPG, JPEG, PNG, PDF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah file.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="fakultas">Fakultas <span class="text-danger">*</span></label>
                            <select class="form-control @error('fakultas') is-invalid @enderror" 
                                    id="fakultas" name="fakultas" required>
                                <option value="">Pilih Fakultas</option>
                                <option value="Teknik" {{ old('fakultas', $pelapor->fakultas) == 'Teknik' ? 'selected' : '' }}>Teknik</option>
                                <option value="Hukum" {{ old('fakultas', $pelapor->fakultas) == 'Hukum' ? 'selected' : '' }}>Hukum</option>
                                <option value="Pertanian" {{ old('fakultas', $pelapor->fakultas) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                <option value="Kedokteran" {{ old('fakultas', $pelapor->fakultas) == 'Kedokteran' ? 'selected' : '' }}>Kedokteran</option>
                                <option value="MIPA" {{ old('fakultas', $pelapor->fakultas) == 'MIPA' ? 'selected' : '' }}>MIPA</option>
                                <option value="Ekonomi dan Bisnis" {{ old('fakultas', $pelapor->fakultas) == 'Ekonomi dan Bisnis' ? 'selected' : '' }}>Ekonomi dan Bisnis</option>
                                <option value="Ilmu Sosial dan Politik" {{ old('fakultas', $pelapor->fakultas) == 'Ilmu Sosial dan Politik' ? 'selected' : '' }}>Ilmu Sosial dan Politik</option>
                            </select>
                            @error('fakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="departemen_prodi">Departemen/Program Studi</label>
                            <input type="text" class="form-control @error('departemen_prodi') is-invalid @enderror" 
                                   id="departemen_prodi" name="departemen_prodi" 
                                   value="{{ old('departemen_prodi', $pelapor->departemen_prodi) }}" 
                                   maxlength="50">
                            @error('departemen_prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit_kerja">Unit Kerja</label>
                            <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" 
                                   id="unit_kerja" name="unit_kerja" 
                                   value="{{ old('unit_kerja', $pelapor->unit_kerja) }}" 
                                   maxlength="50">
                            @error('unit_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $pelapor->email) }}" 
                                   required maxlength="100">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_wa">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_wa') is-invalid @enderror" 
                                   id="no_wa" name="no_wa" 
                                   value="{{ old('no_wa', $pelapor->no_wa) }}" 
                                   required maxlength="15">
                            @error('no_wa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hubungan_korban">Hubungan dengan Korban</label>
                            <select class="form-control @error('hubungan_korban') is-invalid @enderror" 
                                    id="hubungan_korban" name="hubungan_korban">
                                <option value="">Pilih Hubungan</option>
                                <option value="diri sendiri" {{ old('hubungan_korban', $pelapor->hubungan_korban) == 'diri sendiri' ? 'selected' : '' }}>Diri Sendiri</option>
                                <option value="teman" {{ old('hubungan_korban', $pelapor->hubungan_korban) == 'teman' ? 'selected' : '' }}>Teman</option>
                                <option value="keluarga" {{ old('hubungan_korban', $pelapor->hubungan_korban) == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                                <option value="lainnya" {{ old('hubungan_korban', $pelapor->hubungan_korban) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('hubungan_korban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.pelapor.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 