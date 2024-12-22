@extends('admin.layout')

@section('title', 'Edit Kasus')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Kasus</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kasus.update', $kasus->id_kasus) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode_pengaduan">Kode Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_pengaduan') is-invalid @enderror" 
                                   id="kode_pengaduan" name="kode_pengaduan" 
                                   value="{{ old('kode_pengaduan', $kasus->kode_pengaduan) }}" 
                                   required maxlength="6">
                            @error('kode_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_pelapor">Pelapor <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_pelapor') is-invalid @enderror" 
                                    id="id_pelapor" name="id_pelapor" required>
                                <option value="">Pilih Pelapor</option>
                                @foreach($pelapor as $p)
                                    <option value="{{ $p->id_pelapor }}" 
                                        {{ old('id_pelapor', $kasus->id_pelapor) == $p->id_pelapor ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap }} - {{ $p->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_pelapor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_masalah">Jenis Masalah <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis_masalah') is-invalid @enderror" 
                                    id="jenis_masalah" name="jenis_masalah" required>
                                <option value="">Pilih Jenis Masalah</option>
                                @foreach(['bullying', 'kekerasan seksual', 'pelecehan verbal', 'diskriminasi', 'cyberbullying', 'lainnya'] as $jenis)
                                    <option value="{{ $jenis }}" 
                                        {{ old('jenis_masalah', $kasus->jenis_masalah) == $jenis ? 'selected' : '' }}>
                                        {{ ucfirst($jenis) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_masalah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="urgensi">Tingkat Urgensi <span class="text-danger">*</span></label>
                            <select class="form-control @error('urgensi') is-invalid @enderror" 
                                    id="urgensi" name="urgensi" required>
                                <option value="">Pilih Tingkat Urgensi</option>
                                @foreach(['segera', 'dalam beberapa hari', 'tidak mendesak'] as $u)
                                    <option value="{{ $u }}" 
                                        {{ old('urgensi', $kasus->urgensi) == $u ? 'selected' : '' }}>
                                        {{ ucfirst($u) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('urgensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="dampak">Dampak <span class="text-danger">*</span></label>
                            <select class="form-control @error('dampak') is-invalid @enderror" 
                                    id="dampak" name="dampak" required>
                                <option value="">Pilih Dampak</option>
                                @foreach(['sangat besar', 'sedang', 'kecil'] as $d)
                                    <option value="{{ $d }}" 
                                        {{ old('dampak', $kasus->dampak) == $d ? 'selected' : '' }}>
                                        {{ ucfirst($d) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dampak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_pengaduan">Status Pengaduan <span class="text-danger">*</span></label>
                            <select class="form-control @error('status_pengaduan') is-invalid @enderror" 
                                    id="status_pengaduan" name="status_pengaduan" required>
                                <option value="">Pilih Status</option>
                                @foreach(['perlu dikonfirmasi', 'dikonfirmasi', 'ditolak', 'proses satgas', 'selesai'] as $status)
                                    <option value="{{ $status }}" 
                                        {{ old('status_pengaduan', $kasus->status_pengaduan) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_kemahasiswaan">Kemahasiswaan</label>
                            <select class="form-control @error('id_kemahasiswaan') is-invalid @enderror" 
                                    id="id_kemahasiswaan" name="id_kemahasiswaan">
                                <option value="">Pilih Kemahasiswaan</option>
                                @foreach($kemahasiswaan as $k)
                                    <option value="{{ $k->id_kemahasiswaan }}" 
                                        {{ old('id_kemahasiswaan', $kasus->id_kemahasiswaan) == $k->id_kemahasiswaan ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kemahasiswaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_pengaduan">Tanggal Pengaduan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pengaduan') is-invalid @enderror" 
                                   id="tanggal_pengaduan" name="tanggal_pengaduan" 
                                   value="{{ old('tanggal_pengaduan', $kasus->tanggal_pengaduan) }}" required>
                            @error('tanggal_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_konfirmasi">Tanggal Konfirmasi</label>
                            <input type="date" class="form-control @error('tanggal_konfirmasi') is-invalid @enderror" 
                                   id="tanggal_konfirmasi" name="tanggal_konfirmasi" 
                                   value="{{ old('tanggal_konfirmasi', $kasus->tanggal_konfirmasi) }}">
                            @error('tanggal_konfirmasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="asal_fakultas">Asal Fakultas <span class="text-danger">*</span></label>
                            <select class="form-control @error('asal_fakultas') is-invalid @enderror" 
                                    id="asal_fakultas" name="asal_fakultas" required>
                                <option value="">Pilih Fakultas</option>
                                @foreach(['Teknik', 'Hukum', 'Pertanian', 'Kedokteran', 'MIPA', 'Ekonomi dan Bisnis', 'Ilmu Sosial dan Politik'] as $fakultas)
                                    <option value="{{ $fakultas }}" 
                                        {{ old('asal_fakultas', $kasus->asal_fakultas) == $fakultas ? 'selected' : '' }}>
                                        {{ $fakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asal_fakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bukti_kasus">Bukti Kasus</label>
                            @if($kasus->bukti_kasus)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($kasus->bukti_kasus) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-file"></i> Lihat File Saat Ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('bukti_kasus') is-invalid @enderror" 
                                   id="bukti_kasus" name="bukti_kasus">
                            @error('bukti_kasus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Format: JPG, JPEG, PNG, PDF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah file.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_kasus">Deskripsi Kasus <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_kasus') is-invalid @enderror" 
                              id="deskripsi_kasus" name="deskripsi_kasus" rows="4" required>{{ old('deskripsi_kasus', $kasus->deskripsi_kasus) }}</textarea>
                    @error('deskripsi_kasus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="catatan_penanganan">Catatan Penanganan</label>
                    <textarea class="form-control @error('catatan_penanganan') is-invalid @enderror" 
                              id="catatan_penanganan" name="catatan_penanganan" rows="3">{{ old('catatan_penanganan', $kasus->catatan_penanganan) }}</textarea>
                    @error('catatan_penanganan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.kasus.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 