@extends('Pelapor.layout')

@section('title', 'Ajukan Pengaduan')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card w-100 border-left-info shadow-sm h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle mr-2"></i>Form Pengaduan
                    </div>
                    <div class="text-muted small">
                        Silakan lengkapi form pengaduan dengan informasi yang akurat
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card shadow mb-4">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fas fa-file-alt fa-2x mr-3"></i>
            <h6 class="m-0 font-weight-bold">Form Pengaduan</h6>
        </div>
    </div>
    <div class="card-body">
        <!-- Progress Steps -->
        <div class="progress-steps mb-4">
            <div class="step active">
                <span>1</span>
                <p>Data Pelapor</p>
            </div>
            <div class="step">
                <span>2</span>
                <p>Detail Kasus</p>
            </div>
            <div class="step">
                <span>3</span>
                <p>Bukti & Urgensi</p>
            </div>
        </div>

        <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Step 1: Data Pelapor -->
            <div class="form-step" id="step-1">
                <!-- Nama Lengkap Pelapor -->
                <div class="form-group">
                    <label for="nama_lengkap">
                        <i class="fas fa-user text-primary mr-2"></i>Nama Lengkap Pelapor
                    </label>
                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" 
                           placeholder="Masukkan Nama Lengkap Anda" required>
                </div>

                <!-- Nama Panggilan -->
                <div class="form-group">
                    <label for="nama_panggilan">
                        <i class="fas fa-user-tag text-primary mr-2"></i>Nama Panggilan
                    </label>
                    <input type="text" class="form-control" name="nama_panggilan" id="nama_panggilan" 
                           placeholder="Masukkan Nama Panggilan">
                </div>

                <!-- Unsur -->
                <div class="form-group">
                    <label for="unsur">
                        <i class="fas fa-users text-primary mr-2"></i>Unsur
                    </label>
                    <select class="form-control select2" name="unsur" id="unsur" required>
                        <option value="" disabled selected>Pilih Unsur</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="tenaga kependidikan">Tenaga Kependidikan</option>
                        <option value="warga kampus">Warga Kampus</option>
                        <option value="bukan dosen/mahasiswa/tenaga pendidik/warga kampus universitas bengkulu">Bukan Dosen/Mahasiswa/Tenaga Pendidik/Warga Kampus Universitas Bengkulu</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div id="unsur-form" style="display: none;">
                    <div class="form-group">
                        <input type="text" class="form-control" id="other" name="other" 
                               placeholder="Masukkan hubungan lainnya">
                    </div>
                </div>

                <!-- Bukti Identitas -->
                <div class="form-group">
                    <label for="bukti_identitas">
                        <i class="fas fa-id-card text-primary mr-2"></i>Bukti Identitas (KTP/KTM/Kartu Identitas Lainnya)
                    </label>
                    <div class="custom-file-upload" id="dropzone">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Drag & drop file atau klik untuk memilih</p>
                        <input type="file" class="form-control-file" name="bukti_identitas" id="bukti_identitas" required>
                    </div>
                </div>

                <!-- Asal Fakultas -->
                <div class="form-group">
                    <label for="fakultas">
                        <i class="fas fa-university text-primary mr-2"></i>Asal Fakultas
                    </label>
                    <select class="form-control select2" name="fakultas" id="fakultas">
                        <option value="" disabled selected>Pilih Fakultas</option>
                        <option value="Teknik">Fakultas Teknik</option>
                        <option value="Hukum">Fakultas Hukum</option>
                        <option value="Pertanian">Fakultas Pertanian</option>
                        <option value="Ilmu Sosial dan Ilmu Politik">Fakultas Ilmu Sosial dan Ilmu Politik</option>
                        <option value="Keguruan dan Ilmu Pendidikan">Fakultas Keguruan dan Ilmu Pendidikan</option>
                        <option value="Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                        <option value="Kedokteran dan Ilmu Kesehatan">Fakultas Kedokteran dan Ilmu Kesehatan</option>
                        <option value="Matematika dan Ilmu Pengetahuan Alam">Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                    </select>
                </div>

                <!-- Unit Kerja -->
                <div id="unit-kerja-form" style="display: none;">
                    <div class="form-group">
                        <label for="unit_kerja">
                            <i class="fas fa-building text-primary mr-2"></i>Unit Kerja (Untuk tenaga pendidikan)
                        </label>
                        <input type="text" class="form-control" name="unit_kerja" id="unit_kerja" 
                               placeholder="Masukkan Unit Kerja">
                    </div>
                </div>

                <!-- Departemen dan Prodi -->
                <div id="departemen-prodi-form" style="display: none;">
                    <div class="form-group">
                        <label for="departemen_prodi">
                            <i class="fas fa-graduation-cap text-primary mr-2"></i>Asal Departemen dan Program Studi
                        </label>
                        <input type="text" class="form-control" name="departemen_prodi" id="departemen_prodi" 
                               placeholder="Masukkan Departemen dan Program Studi">
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope text-primary mr-2"></i>Alamat Surel Pelapor
                    </label>
                    <input type="email" class="form-control" name="email" id="email" 
                           placeholder="Masukkan Alamat Surel Anda" required>
                </div>

                <!-- WhatsApp -->
                <div class="form-group">
                    <label for="no_wa">
                        <i class="fab fa-whatsapp text-primary mr-2"></i>Nomor WhatsApp Pelapor
                    </label>
                    <input type="text" class="form-control" name="no_wa" id="no_wa" 
                           placeholder="Masukkan Nomor WhatsApp Anda" required>
                </div>
            </div>

            <!-- Step 2: Detail Kasus -->
            <div class="form-step" id="step-2" style="display: none;">
                <!-- Melapor Kasus Sebagai -->
                <div class="form-group">
                    <label for="melapor_sebagai">
                        <i class="fas fa-user-shield text-primary mr-2"></i>Melapor Kasus Sebagai
                    </label>
                    <select class="form-control select2" name="melapor_sebagai" id="melapor_sebagai" required>
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="Korban">Korban</option>
                        <option value="Perwakilan Korban">Perwakilan Korban</option>
                        <option value="Saksi">Saksi</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div id="melapor-form" style="display: none;">
                    <div class="form-group">
                        <input type="text" class="form-control" id="melapor_other" name="melapor_other" 
                               placeholder="Masukkan status lainnya">
                    </div>
                </div>

                <!-- Hubungan Pelapor dengan Korban -->
                <div class="form-group">
                    <label for="hubungan_korban">
                        <i class="fas fa-people-arrows text-primary mr-2"></i>Hubungan Pelapor dengan Korban
                    </label>
                    <select class="form-control select2" name="hubungan_korban" id="hubungan_korban" required>
                        <option value="" disabled selected>Pilih Hubungan</option>
                        <option value="diri sendiri">Diri Sendiri</option>
                        <option value="teman">Teman</option>
                        <option value="keluarga">Keluarga</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div id="hubungan-form" style="display: none;">
                    <div class="form-group">
                        <input type="text" class="form-control" id="hubungan_other" name="hubungan_other" 
                               placeholder="Masukkan hubungan lainnya">
                    </div>
                </div>
            </div>

            <!-- Step 3: Bukti & Urgensi -->
            <div class="form-step" id="step-3" style="display: none;">
                <!-- Jenis Masalah -->
                <div class="form-group">
                    <label for="jenis_masalah">
                        <i class="fas fa-exclamation-triangle text-primary mr-2"></i>Jenis Masalah
                    </label>
                    <select class="form-control select2" name="jenis_masalah" id="jenis_masalah" required>
                        <option value="" disabled selected>Pilih Jenis Masalah</option>
                        <option value="bullying">Bullying</option>
                        <option value="kekerasan seksual">Kekerasan Seksual</option>
                        <option value="pelecehan verbal">Pelecehan Verbal/Cacian</option>
                        <option value="diskriminasi">Diskriminasi</option>
                        <option value="cyberbullying">Perundungan Siber</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Keterangan Tambahan -->
                <div class="form-group">
                    <label for="deskripsi_kasus">
                        <i class="fas fa-align-left text-primary mr-2"></i>Keterangan Tambahan
                    </label>
                    <textarea class="form-control" name="deskripsi_kasus" id="deskripsi_kasus" rows="4" 
                              placeholder="Deskripsi detail tentang kasus" required></textarea>
                </div>

                <!-- Bukti Kasus -->
                <div class="form-group">
                    <label for="bukti_kasus">
                        <i class="fas fa-file-upload text-primary mr-2"></i>Bukti Kasus Yang Terjadi (opsional)
                    </label>
                    <div class="custom-file-upload" id="dropzone">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Drag & drop file atau klik untuk memilih</p>
                        <input type="file" class="form-control-file" name="bukti_kasus" id="bukti_kasus">
                    </div>
                </div>

                <!-- Urgensi -->
                <div class="form-group">
                    <label for="urgensi">
                        <i class="fas fa-clock text-primary mr-2"></i>Urgensi
                    </label>
                    <select class="form-control select2" name="urgensi" id="urgensi" required>
                        <option value="" disabled selected>Pilih Urgensi</option>
                        <option value="segera">Segera</option>
                        <option value="dalam beberapa hari">Dalam Beberapa Hari</option>
                        <option value="tidak mendesak">Tidak Mendesak</option>
                    </select>
                </div>

                <!-- Dampak -->
                <div class="form-group">
                    <label for="dampak">
                        <i class="fas fa-impact text-primary mr-2"></i>Dampak
                    </label>
                    <select class="form-control select2" name="dampak" id="dampak" required>
                        <option value="" disabled selected>Pilih Dampak</option>
                        <option value="sangat besar">Sangat Besar</option>
                        <option value="sedang">Sedang</option>
                        <option value="kecil">Kecil</option>
                    </select>
                </div>
            </div>

            <!-- Form Navigation -->
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                    <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
                </button>
                <button type="button" class="btn btn-info" id="nextBtn">
                    Selanjutnya<i class="fas fa-arrow-right ml-2"></i>
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pengaduan
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    window.onload = function() {
        // Debug untuk memastikan script berjalan
        console.log('Script loaded for all forms');
        
        // Unsur
        var unsurSelect = document.getElementById('unsur');
        var unsurForm = document.getElementById('unsur-form');
        var departemenProdiForm = document.getElementById('departemen-prodi-form');
        var unitKerjaForm = document.getElementById('unit-kerja-form');
        
        if(unsurSelect) {
            unsurSelect.addEventListener('change', function() {
                console.log('Unsur selected value:', this.value);
                
                // Reset semua form terkait unsur
                unsurForm.style.display = 'none';
                departemenProdiForm.style.display = 'none';
                unitKerjaForm.style.display = 'none';
                
                document.getElementById('other').required = false;
                document.getElementById('departemen_prodi').required = false;
                document.getElementById('unit_kerja').required = false;
                
                // Tampilkan form sesuai pilihan
                switch(this.value) {
                    case 'lainnya':
                        unsurForm.style.display = 'block';
                        document.getElementById('other').required = true;
                        break;
                    case 'dosen':
                    case 'mahasiswa':
                        departemenProdiForm.style.display = 'block';
                        document.getElementById('departemen_prodi').required = true;
                        break;
                    case 'tenaga kependidikan':
                        unitKerjaForm.style.display = 'block';
                        document.getElementById('unit_kerja').required = true;
                        break;
                }
            });
        }

        // Melapor Sebagai
        var melaporSelect = document.getElementById('melapor_sebagai');
        var melaporForm = document.getElementById('melapor-form');
        
        if(melaporSelect) {
            melaporSelect.addEventListener('change', function() {
                console.log('Melapor selected value:', this.value);
                if(this.value === 'lainnya') {
                    melaporForm.style.display = 'block';
                    document.getElementById('melapor_other').required = true;
                } else {
                    melaporForm.style.display = 'none';
                    document.getElementById('melapor_other').required = false;
                }
            });
        }

        // Hubungan dengan Korban
        var hubunganSelect = document.getElementById('hubungan_korban');
        var hubunganForm = document.getElementById('hubungan-form');
        
        if(hubunganSelect) {
            hubunganSelect.addEventListener('change', function() {
                console.log('Hubungan selected value:', this.value);
                if(this.value === 'lainnya') {
                    hubunganForm.style.display = 'block';
                    document.getElementById('hubungan_other').required = true;
                } else {
                    hubunganForm.style.display = 'none';
                    document.getElementById('hubungan_other').required = false;
                }
            });
        }
    };
    
</script>

@push('scripts')
<script>
    // Inisialisasi Select2
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush

@endsection

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