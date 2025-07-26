@extends('admin.layout')

@section('title', 'Edit Kasus')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kasus</h1>
        <a href="{{ route('admin.kasus.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Kasus</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kasus.update', $kasus->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No Pengaduan</label>
                            <input type="text"
                                   name="no_pengaduan"
                                   class="form-control @error('no_pengaduan') is-invalid @enderror"
                                   value="{{ old('no_pengaduan', $kasus->no_pengaduan) }}"
                                   required>
                            @error('no_pengaduan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Pelapor</label>
                            <select name="pelapor_id"
                                    class="form-control @error('pelapor_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Pelapor --</option>
                                @foreach($pelapor as $p)
                                <option value="{{ $p->id_pelapor }}"
                                        {{ old('pelapor_id', $kasus->pelapor_id) == $p->id_pelapor ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }}
                                </option>
                                @endforeach
                            </select>
                            @error('pelapor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Judul Pengaduan</label>
                            <input type="text"
                                   name="judul_pengaduan"
                                   class="form-control @error('judul_pengaduan') is-invalid @enderror"
                                   value="{{ old('judul_pengaduan', $kasus->judul_pengaduan) }}"
                                   required>
                            @error('judul_pengaduan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Lokasi Fasilitas</label>
                            <input type="text"
                                   name="lokasi_fasilitas"
                                   class="form-control @error('lokasi_fasilitas') is-invalid @enderror"
                                   value="{{ old('lokasi_fasilitas', $kasus->lokasi_fasilitas) }}"
                                   required>
                            @error('lokasi_fasilitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Fasilitas</label>
                            <input type="text"
                                   name="jenis_fasilitas"
                                   class="form-control @error('jenis_fasilitas') is-invalid @enderror"
                                   value="{{ old('jenis_fasilitas', $kasus->jenis_fasilitas) }}"
                                   required>
                            @error('jenis_fasilitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tingkat Urgensi</label>
                            <select name="tingkat_urgensi"
                                    class="form-control @error('tingkat_urgensi') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Tingkat Urgensi --</option>
                                @foreach(['Rendah', 'Sedang', 'Tinggi'] as $urgensi)
                                <option value="{{ $urgensi }}"
                                        {{ old('tingkat_urgensi', $kasus->tingkat_urgensi) == $urgensi ? 'selected' : '' }}>
                                    {{ $urgensi }}
                                </option>
                                @endforeach
                            </select>
                            @error('tingkat_urgensi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Status --</option>
                                @foreach(['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $status)
                                <option value="{{ $status }}"
                                        {{ old('status', $kasus->status) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Pengaduan</label>
                            <input type="date"
                                   name="tanggal_pengaduan"
                                   class="form-control @error('tanggal_pengaduan') is-invalid @enderror"
                                   value="{{ old('tanggal_pengaduan', ($kasus->tanggal_pengaduan instanceof \Carbon\Carbon) ? $kasus->tanggal_pengaduan->format('Y-m-d') : \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('Y-m-d')) }}"
                                   required>
                            @error('tanggal_pengaduan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Foto Bukti</label>
                            <input type="file"
                                   name="foto_bukti"
                                   class="form-control @error('foto_bukti') is-invalid @enderror"
                                   accept="image/*">
                            @error('foto_bukti')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($kasus->foto_bukti)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$kasus->foto_bukti) }}"
                                     alt="Foto Bukti"
                                     class="img-thumbnail"
                                     style="max-height: 200px">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="4"
                                      required>{{ old('deskripsi', $kasus->deskripsi) }}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Catatan Admin</label>
                            <textarea name="catatan_admin"
                                      class="form-control @error('catatan_admin') is-invalid @enderror"
                                      rows="4">{{ old('catatan_admin', $kasus->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Catatan Pimpinan</label>
                            <textarea name="catatan_satgas"
                                      class="form-control @error('catatan_satgas') is-invalid @enderror"
                                      rows="4">{{ old('catatan_satgas', $kasus->catatan_satgas) }}</textarea>
                            @error('catatan_satgas')
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
