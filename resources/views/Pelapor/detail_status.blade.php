@extends('pelapor.layout')

@section('title', 'Detail Status Pengaduan')

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
                        <div class="status-badge {{ $kasus->status_pengaduan == 'selesai' ? 'done' : ($kasus->status_pengaduan == 'proses satgas' ? 'process' : ($kasus->status_pengaduan == 'dikonfirmasi' ? 'confirmed' : ($kasus->status_pengaduan == 'ditolak' ? 'rejected' : 'pending'))) }}">
                            <i class="fas {{ $kasus->status_pengaduan == 'selesai' ? 'fa-check-double' : ($kasus->status_pengaduan == 'proses satgas' ? 'fa-tools' : ($kasus->status_pengaduan == 'dikonfirmasi' ? 'fa-check' : ($kasus->status_pengaduan == 'ditolak' ? 'fa-times' : 'fa-clock'))) }}"></i>
                            {{ ucfirst($kasus->status_pengaduan) }}
                        </div>
                        <h5 class="text-muted mb-2">Kode Pengaduan</h5>
                        <h2 class="font-weight-bold text-primary mb-0" id="kodePengaduan">{{ $kasus->kode_pengaduan }}</h2>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyKode()">
                            <i class="fas fa-copy mr-1"></i>Salin Kode
                        </button>
                    </div>

                    <!-- Status dan Timeline yang sudah ada tetap dipertahankan -->
                    <div class="status-section mb-4">
                        @switch($kasus->status_pengaduan)
                            @case('perlu dikonfirmasi')
                                <div class="alert alert-warning">
                                    <h5 class="alert-heading"><i class="fas fa-clock mr-2"></i>Menunggu Konfirmasi</h5>
                                    <hr>
                                    <p class="mb-0">Pengaduan Anda telah kami terima dan sedang menunggu konfirmasi dari tim Kemahasiswaan. 
                                    Mohon bersabar, kami akan segera memproses laporan Anda.</p>
                                </div>
                                @break

                            @case('dikonfirmasi')
                                <div class="alert alert-info">
                                    <h5 class="alert-heading"><i class="fas fa-check-circle mr-2"></i>Pengaduan Dikonfirmasi</h5>
                                    <hr>
                                    <p>Pengaduan Anda telah dikonfirmasi pada tanggal 
                                    <strong>{{ \Carbon\Carbon::parse($kasus->tanggal_konfirmasi)->isoFormat('D MMMM Y') }}</strong>.</p>
                                    <p class="mb-0">Tim Satgas akan segera menindaklanjuti kasus Anda. Kami berkomitmen untuk memberikan 
                                    penanganan terbaik.</p>
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
                                    <h5 class="alert-heading"><i class="fas fa-tools mr-2"></i>Dalam Penanganan Satgas</h5>
                                    <hr>
                                    <p>Kabar baik! Kasus Anda sedang dalam penanganan aktif oleh Tim Satgas kami.</p>
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
                                    <p class="mb-0 mt-3">Kami akan memastikan penanganan dilakukan secara profesional dan menyeluruh. 
                                    Terima kasih atas kepercayaan Anda kepada kami.</p>
                                </div>
                                @break

                            @case('selesai')
                                <div class="alert alert-success">
                                    <h5 class="alert-heading"><i class="fas fa-check-double mr-2"></i>Kasus Selesai</h5>
                                    <hr>
                                    <p>Selamat! Pengaduan Anda telah selesai ditangani oleh Tim Satgas.</p>
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
                                    <p class="mb-0 mt-3">Terima kasih atas kepercayaan Anda kepada kami dalam menangani kasus ini.</p>
                                </div>
                                @break
                        @endswitch
                    </div>

                    <!-- Detail Pengaduan dengan styling baru -->
                    <div class="card detail-card mb-4">
                        <div class="card-header">
                            <h6 class="font-weight-bold mb-0">
                                <i class="fas fa-info-circle mr-2"></i>Detail Pengaduan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-info">
                                        <strong>Tanggal Pengaduan</strong>
                                        <p>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->isoFormat('dddd, D MMMM Y') }}</p>
                                    </div>
                                    <div class="detail-info">
                                        <strong>Jenis Masalah</strong>
                                        <p>{{ ucfirst($kasus->jenis_masalah) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-info">
                                        <strong>Urgensi</strong>
                                        <p>{{ ucfirst($kasus->urgensi) }}</p>
                                    </div>
                                    <div class="detail-info">
                                        <strong>Dampak</strong>
                                        <p>{{ ucfirst($kasus->dampak) }}</p>
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