@extends('pelapor.layout')

@section('title', 'Dashboard')

@section('content')
<div class="welcome-banner mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1 class="welcome-title">Selamat Datang di Layanan Pengaduan Fasilitas Klinik Inggit</h1>
            <p class="welcome-subtitle">Laporkan masalah fasilitas yang Anda alami atau ketahui. Kami siap membantu menangani laporan Anda dengan profesional dan rahasia.</p>
        </div>
        <div class="col-lg-4 text-center">
            <img src="{{asset('assets/img/welcome.png')}}" alt="Welcome" class="welcome-image">
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('pelapor.ajukan_pengaduan') }}" class="quick-action-card">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <h5>Buat Pengaduan Baru</h5>
                            <p>Laporkan masalah fasilitas yang Anda alami</p>
                        </a>
                    </div>
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('pengaduan.progress') }}" class="quick-action-card">
                            <div class="icon-circle bg-info">
                                <i class="fas fa-search text-white"></i>
                            </div>
                            <h5>Cek Status Pengaduan</h5>
                            <p>Pantau perkembangan laporan fasilitas Anda</p>
                        </a>
                    </div>
                    <div class="col-md-4 mb-4">
                        <a href="#" class="quick-action-card" data-toggle="modal" data-target="#panduan">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <h5>Panduan Pengaduan</h5>
                            <p>Pelajari cara membuat pengaduan fasilitas yang baik</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Penting -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">Informasi Penting</h6>
            </div>
            <div class="card-body">
                <div class="info-items">
                    <div class="info-item">
                        <div class="info-icon bg-warning">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="info-content">
                            <h6>Kerahasiaan Terjamin</h6>
                            <p>Identitas pelapor akan dijaga kerahasiaannya dan hanya diketahui oleh Tim Fasilitas</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon bg-info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <h6>Penanganan 24 Jam</h6>
                            <p>Tim Fasilitas siap menangani laporan Anda selama 24 jam</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon bg-success">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="info-content">
                            <h6>Tim Profesional</h6>
                            <p>Ditangani oleh Tim Fasilitas yang terlatih dan berpengalaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">Kontak Darurat</h6>
            </div>
            <div class="card-body">
                <div class="emergency-contacts">
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <div>
                            <h6>Hotline Fasilitas</h6>
                            <p>0812-3456-7890</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h6>Email</h6>
                            <p>fasilitas@klinik-inn.git</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h6>Kantor Fasilitas</h6>
                            <p>Gedung Rektorat Lt. 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Panduan -->
<div class="modal fade" id="panduan" tabindex="-1" role="dialog" aria-labelledby="panduanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="panduanLabel">Panduan Pengaduan Fasilitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panduan-steps">
                    <div class="panduan-step">
                        <div class="step-number">1</div>
                        <h6>Persiapkan Informasi</h6>
                        <p>Siapkan informasi detail tentang fasilitas yang akan dilaporkan</p>
                    </div>
                    <div class="panduan-step">
                        <div class="step-number">2</div>
                        <h6>Pilih Jenis Fasilitas</h6>
                        <p>Tentukan kategori fasilitas yang sesuai dengan laporan Anda</p>
                    </div>
                    <div class="panduan-step">
                        <div class="step-number">3</div>
                        <h6>Lengkapi Form</h6>
                        <p>Isi semua informasi yang diperlukan dengan lengkap dan jelas</p>
                    </div>
                    <div class="panduan-step">
                        <div class="step-number">4</div>
                        <h6>Lampirkan Bukti</h6>
                        <p>Sertakan bukti pendukung jika ada (foto, dokumen, dll)</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="{{ route('pelapor.ajukan_pengaduan') }}" class="btn btn-primary">Buat Pengaduan</a>
            </div>
        </div>
    </div>
</div>
@endsection