@extends('pelapor.layout')

@section('title', 'Detail Status Pengaduan Fasilitas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="text-center font-weight-bold my-4">
                        <i class="fas fa-file-alt mr-2"></i>Detail Status Pengaduan
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Kode Pengaduan -->
                    <div class="text-center mb-4">
                        <div class="status-badge {{ 
                            $kasus->status == 'selesai' ? 'done' : 
                            ($kasus->status == 'proses satgas' ? 'process' : 
                            ($kasus->status == 'dikonfirmasi' ? 'confirmed' : 
                            ($kasus->status == 'ditolak' ? 'rejected' : 'pending'))) 
                        }}">
                            <i class="fas {{ $kasus->status == 'selesai' ? 'fa-check-double' : ($kasus->status == 'proses satgas' ? 'fa-tools' : ($kasus->status == 'dikonfirmasi' ? 'fa-check' : ($kasus->status == 'ditolak' ? 'fa-times' : 'fa-clock'))) }}"></i>
                            {{ ucfirst($kasus->status) }}
                        </div>
                        <h5 class="text-muted mb-2">Kode Pengaduan</h5>
                        <h2 class="font-weight-bold text-primary mb-0" id="kodePengaduan">{{ $kasus->no_pengaduan }}</h2>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyKode()">
                            <i class="fas fa-copy mr-1"></i>Salin Kode
                        </button>
                    </div>

                    <!-- Status dan Timeline yang sudah ada tetap dipertahankan -->
                    <div class="status-section mb-4">
                        @switch($kasus->status)
                            @case('perlu dikonfirmasi')
                                <div class="alert alert-warning">
                                    <h5 class="alert-heading"><i class="fas fa-clock mr-2"></i>Menunggu Konfirmasi</h5>
                                    <hr>
                                    <p class="mb-0">Pengaduan Anda telah kami terima dan sedang menunggu konfirmasi dari <b>Admin Fasilitas</b>. 
                                    Mohon bersabar, kami akan segera memproses laporan Anda.</p>
                                </div>
                                @break

                            @case('dikonfirmasi')
                                <div class="alert alert-info">
                                    <h5 class="alert-heading"><i class="fas fa-check-circle mr-2"></i>Pengaduan Dikonfirmasi</h5>
                                    <hr>
                                    <p>Pengaduan Anda telah dikonfirmasi pada tanggal 
                                    <strong>{{ \Carbon\Carbon::parse($kasus->tanggal_konfirmasi)->isoFormat('D MMMM Y') }}</strong>.</p>
                                    <p class="mb-0">Tim Fasilitas akan segera menindaklanjuti laporan Anda. Kami berkomitmen untuk memberikan penanganan terbaik.</p>
                                </div>
                                @break

                            @case('ditolak')
                                <div class="alert alert-danger">
                                    <h5 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Pengaduan Tidak Dapat Diproses</h5>
                                    <hr>
                                    <p class="mb-0">Mohon maaf, setelah melakukan peninjauan mendalam, pengaduan Anda tidak dapat kami proses lebih lanjut. 
                                    @if($kasus->catatan_penanganan)
                                        <br><br>
                                        <strong>Catatan:</strong><br>
                                        {{ $kasus->catatan_penanganan }}
                                    @endif
                                    </p>
                                </div>
                                @break

                            @case('proses satgas')
                                <div class="alert alert-primary">
                                    <h5 class="alert-heading"><i class="fas fa-tools mr-2"></i>Dalam Penanganan Tim Fasilitas</h5>
                                    <hr>
                                    <p>Kabar baik! Laporan Anda sedang dalam penanganan aktif oleh <b>Tim Fasilitas</b> kami.</p>
                                    <div class="timeline mt-3">
                                        <div class="timeline-item">
                                            <i class="fas fa-check-circle text-success"></i>
                                            <strong>Tanggal Konfirmasi:</strong>
                                            {{ \Carbon\Carbon::parse($kasus->tanggal_konfirmasi)->isoFormat('D MMMM Y') }}
                                        </div>
                                        <div class="timeline-item">
                                            <i class="fas fa-clock text-primary"></i>
                                            <strong>Tanggal Mulai Penanganan:</strong>
                                            {{ \Carbon\Carbon::parse($kasus->satgas->first()->pivot->tanggal_tindak_lanjut)->isoFormat('D MMMM Y') }}
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-3">Kami akan memastikan penanganan dilakukan secara profesional dan menyeluruh. Terima kasih atas kepercayaan Anda kepada kami.</p>
                                </div>
                                @break

                            @case('selesai')
                                <div class="alert alert-success">
                                    <h5 class="alert-heading"><i class="fas fa-check-double mr-2"></i>Laporan Selesai</h5>
                                    <hr>
                                    <p>Selamat! Laporan Anda telah selesai ditangani oleh <b>Tim Fasilitas</b>.</p>
                                    <div class="timeline mt-3">
                                        <div class="timeline-item">
                                            <i class="fas fa-check-circle text-success"></i>
                                            <strong>Tanggal Konfirmasi:</strong>
                                            {{ \Carbon\Carbon::parse($kasus->tanggal_konfirmasi)->isoFormat('D MMMM Y') }}
                                        </div>
                                        <div class="timeline-item">
                                            <i class="fas fa-clock text-primary"></i>
                                            <strong>Tanggal Mulai Penanganan:</strong>
                                            {{ \Carbon\Carbon::parse($kasus->satgas->first()->pivot->tanggal_tindak_lanjut)->isoFormat('D MMMM Y') }}
                                        </div>
                                        <div class="timeline-item">
                                            <i class="fas fa-flag-checkered text-success"></i>
                                            <strong>Tanggal Selesai:</strong>
                                            {{ \Carbon\Carbon::parse($kasus->satgas->first()->pivot->tanggal_tindak_selesai)->isoFormat('D MMMM Y') }}
                                        </div>
                                    </div>
                                    @if($kasus->catatan_penanganan)
                                        <p class="mt-3"><strong>Hasil Penanganan:</strong><br>
                                        {{ $kasus->catatan_penanganan }}</p>
                                    @endif
                                    <p class="mb-0 mt-3">Terima kasih atas kepercayaan Anda kepada kami dalam menangani laporan fasilitas ini.</p>
                                </div>
                                @break
                        @endswitch
                    </div>

                    <!-- Detail Pengaduan dengan styling baru -->
                    <div class="card detail-card mb-4">
                        <div class="card-header">
                            <h6 class="font-weight-bold mb-0">
                                <i class="fas fa-info-circle mr-2"></i>Detail Pengaduan Fasilitas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-info">
                                        <strong>Judul Pengaduan</strong>
                                        <p>{{ $kasus->judul_pengaduan }}</p>
                                    </div>
                                    <div class="detail-info">
                                        <strong>Lokasi Fasilitas</strong>
                                        <p>{{ $kasus->lokasi_fasilitas }}</p>
                                    </div>
                                    <div class="detail-info">
                                        <strong>Jenis Fasilitas</strong>
                                        <p>{{ $kasus->jenis_fasilitas }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-info">
                                        <strong>Tingkat Urgensi</strong>
                                        <p>{{ ucfirst($kasus->tingkat_urgensi) }}</p>
                                    </div>
                                    <div class="detail-info">
                                        <strong>Status Pengaduan</strong>
                                        <span class="badge 
                                            {{ $kasus->status == 'selesai' ? 'badge-success' : 
                                                ($kasus->status == 'proses satgas' ? 'badge-primary' : 
                                                ($kasus->status == 'dikonfirmasi' ? 'badge-info' : 
                                                ($kasus->status == 'ditolak' ? 'badge-danger' : 'badge-secondary'))) }}">
                                            {{ ucfirst($kasus->status) }}
                                        </span>
                                    </div>
                                    <div class="detail-info">
                                        <strong>Tanggal Pengaduan</strong>
                                        <p>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->isoFormat('dddd, D MMMM Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="detail-info">
                                        <strong>Deskripsi Pengaduan</strong>
                                        <p>{{ $kasus->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="text-center">
                        <a href="{{ route('pengaduan.progress') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function copyKode() {
    const kodePengaduan = document.getElementById('kodePengaduan').textContent.trim();
    copyToClipboard(kodePengaduan);
}
</script>
@endpush

<style>
.status-badge.done { background: #28a745; color: #fff; }
.status-badge.process { background: #007bff; color: #fff; }
.status-badge.confirmed { background: #17a2b8; color: #fff; }
.status-badge.rejected { background: #dc3545; color: #fff; }
.status-badge.pending { background: #6c757d; color: #fff; }
</style>