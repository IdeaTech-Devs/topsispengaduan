@extends('Pelapor.layout')

@section('title', 'Ajukan Pengaduan Fasilitas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card w-100 border-left-info shadow-sm h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle mr-2"></i>Form Pengaduan Fasilitas
                    </div>
                    <div class="text-muted small">
                        Silakan lengkapi form pengaduan fasilitas dengan informasi yang akurat
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fas fa-file-alt fa-2x mr-3"></i>
            <h6 class="m-0 font-weight-bold">Form Pengaduan Fasilitas</h6>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_lengkap"><i class="fas fa-user text-primary mr-2"></i>Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan Nama Lengkap Anda" required>
            </div>
            <div class="form-group">
                <label for="nama_panggilan"><i class="fas fa-user-tag text-primary mr-2"></i>Nama Panggilan</label>
                <input type="text" class="form-control" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan Nama Panggilan" required>
            </div>
            <div class="form-group">
                <label for="status_pelapor"><i class="fas fa-users text-primary mr-2"></i>Status Pelapor</label>
                <select class="form-control" name="status_pelapor" id="status_pelapor" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="staff">Staff</option>
                    <option value="pengunjung">Pengunjung</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope text-primary mr-2"></i>Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email Anda" required>
            </div>
            <div class="form-group">
                <label for="no_wa"><i class="fab fa-whatsapp text-primary mr-2"></i>No. WhatsApp</label>
                <input type="text" class="form-control" name="no_wa" id="no_wa" placeholder="Masukkan Nomor WhatsApp" required>
            </div>
            <div class="form-group">
                <label for="judul_pengaduan"><i class="fas fa-heading text-primary mr-2"></i>Judul Pengaduan</label>
                <input type="text" class="form-control" name="judul_pengaduan" id="judul_pengaduan" placeholder="Contoh: AC Tidak Dingin di Ruang Tunggu" required>
            </div>
            <div class="form-group">
                <label for="lokasi_fasilitas"><i class="fas fa-map-marker-alt text-primary mr-2"></i>Lokasi Fasilitas</label>
                <select class="form-control select2" name="lokasi_fasilitas" id="lokasi_fasilitas" required>
                    <option value="" disabled selected>Pilih Lokasi Ruang</option>
                    @foreach($ruang as $r)
                        <option value="{{ $r->nama_ruang }}">{{ $r->nama_ruang }} ({{ $r->lokasi }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_fasilitas"><i class="fas fa-cogs text-primary mr-2"></i>Jenis Fasilitas</label>
                <select class="form-control select2" name="jenis_fasilitas" id="jenis_fasilitas" required>
                    <option value="" disabled selected>Pilih Jenis Fasilitas</option>
                    @foreach($jenisFasilitas as $jenis)
                        <option value="{{ $jenis }}">{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi"><i class="fas fa-align-left text-primary mr-2"></i>Deskripsi Pengaduan</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" placeholder="Jelaskan detail masalah fasilitas yang dilaporkan" required></textarea>
            </div>
            <div class="form-group">
                <label for="tingkat_urgensi"><i class="fas fa-clock text-primary mr-2"></i>Tingkat Urgensi</label>
                <select class="form-control" name="tingkat_urgensi" id="tingkat_urgensi" required>
                    <option value="" disabled selected>Pilih Urgensi</option>
                    <option value="Tinggi">Tinggi (Butuh Penanganan Segera)</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Rendah">Rendah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="foto_bukti"><i class="fas fa-image text-primary mr-2"></i>Foto Bukti</label>
                <input type="file" class="form-control-file" name="foto_bukti" id="foto_bukti" accept="image/*" required>
                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pengaduan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi Select2
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush

@push('css')
<style>
.select2-container {
    width: 100% !important;
}

.select2-dropdown {
    z-index: 9999;
}

#dropzone {
    border: 2px dashed #e4e6fc;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
}

#dropzone:hover {
    border-color: var(--primary);
    background: rgba(103, 119, 239, 0.05);
}
</style>


@endpush