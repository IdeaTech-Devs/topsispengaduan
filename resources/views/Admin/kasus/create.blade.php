@extends('admin.layout')

@section('title', 'Tambah Kasus')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Kasus Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kasus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_pengaduan">Kode Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_pengaduan') is-invalid @enderror" 
                                   id="no_pengaduan" name="no_pengaduan" value="{{ old('no_pengaduan') }}" 
                                   required maxlength="6">
                            @error('no_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_pelapor">Pelapor <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_pelapor') is-invalid @enderror" 
                                    id="id_pelapor" name="id_pelapor" required>
                                <option value="">Pilih Pelapor</option>
                                @foreach($pelapor as $p)
                                    <option value="{{ $p->id_pelapor }}" {{ old('id_pelapor') == $p->id_pelapor ? 'selected' : '' }}>
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
                                <option value="bullying" {{ old('jenis_masalah') == 'bullying' ? 'selected' : '' }}>Bullying</option>
                                <option value="kekerasan seksual" {{ old('jenis_masalah') == 'kekerasan seksual' ? 'selected' : '' }}>Kekerasan Seksual</option>
                                <option value="pelecehan verbal" {{ old('jenis_masalah') == 'pelecehan verbal' ? 'selected' : '' }}>Pelecehan Verbal</option>
                                <option value="diskriminasi" {{ old('jenis_masalah') == 'diskriminasi' ? 'selected' : '' }}>Diskriminasi</option>
                                <option value="cyberbullying" {{ old('jenis_masalah') == 'cyberbullying' ? 'selected' : '' }}>Cyberbullying</option>
                                <option value="lainnya" {{ old('jenis_masalah') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                <option value="segera" {{ old('urgensi') == 'segera' ? 'selected' : '' }}>Segera</option>
                                <option value="dalam beberapa hari" {{ old('urgensi') == 'dalam beberapa hari' ? 'selected' : '' }}>Dalam Beberapa Hari</option>
                                <option value="tidak mendesak" {{ old('urgensi') == 'tidak mendesak' ? 'selected' : '' }}>Tidak Mendesak</option>
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
                                <option value="sangat besar" {{ old('dampak') == 'sangat besar' ? 'selected' : '' }}>Sangat Besar</option>
                                <option value="sedang" {{ old('dampak') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="kecil" {{ old('dampak') == 'kecil' ? 'selected' : '' }}>Kecil</option>
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
                                <option value="perlu dikonfirmasi" {{ old('status_pengaduan') == 'perlu dikonfirmasi' ? 'selected' : '' }}>Perlu Dikonfirmasi</option>
                                <option value="dikonfirmasi" {{ old('status_pengaduan') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="ditolak" {{ old('status_pengaduan') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="proses satgas" {{ old('status_pengaduan') == 'proses satgas' ? 'selected' : '' }}>Proses Satgas</option>
                                <option value="selesai" {{ old('status_pengaduan') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_pengaduan">Tanggal Pengaduan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pengaduan') is-invalid @enderror" 
                                   id="tanggal_pengaduan" name="tanggal_pengaduan" 
                                   value="{{ old('tanggal_pengaduan', date('Y-m-d')) }}" required>
                            @error('tanggal_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="asal_fakultas">Asal Fakultas <span class="text-danger">*</span></label>
                            <select class="form-control @error('asal_fakultas') is-invalid @enderror" 
                                    id="asal_fakultas" name="asal_fakultas" required>
                                <option value="">Pilih Fakultas</option>
                                <option value="Teknik" {{ old('asal_fakultas') == 'Teknik' ? 'selected' : '' }}>Teknik</option>
                                <option value="Hukum" {{ old('asal_fakultas') == 'Hukum' ? 'selected' : '' }}>Hukum</option>
                                <option value="Pertanian" {{ old('asal_fakultas') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                <option value="Kedokteran" {{ old('asal_fakultas') == 'Kedokteran' ? 'selected' : '' }}>Kedokteran</option>
                                <option value="MIPA" {{ old('asal_fakultas') == 'MIPA' ? 'selected' : '' }}>MIPA</option>
                                <option value="Ekonomi dan Bisnis" {{ old('asal_fakultas') == 'Ekonomi dan Bisnis' ? 'selected' : '' }}>Ekonomi dan Bisnis</option>
                                <option value="Ilmu Sosial dan Politik" {{ old('asal_fakultas') == 'Ilmu Sosial dan Politik' ? 'selected' : '' }}>Ilmu Sosial dan Politik</option>
                            </select>
                            @error('asal_fakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bukti_kasus">Bukti Kasus</label>
                            <input type="file" class="form-control @error('bukti_kasus') is-invalid @enderror" 
                                   id="bukti_kasus" name="bukti_kasus">
                            @error('bukti_kasus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Format: JPG, JPEG, PNG, PDF. Maksimal 2MB
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_kasus">Deskripsi Kasus <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_kasus') is-invalid @enderror" 
                              id="deskripsi_kasus" name="deskripsi_kasus" rows="4" required>{{ old('deskripsi_kasus') }}</textarea>
                    @error('deskripsi_kasus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="catatan_penanganan">Catatan Penanganan</label>
                    <textarea class="form-control @error('catatan_penanganan') is-invalid @enderror" 
                              id="catatan_penanganan" name="catatan_penanganan" rows="3">{{ old('catatan_penanganan') }}</textarea>
                    @error('catatan_penanganan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.kasus.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 