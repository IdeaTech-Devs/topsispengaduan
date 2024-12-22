@extends('pelapor.layout')

@section('title', 'Pengaduan Berhasil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body success-page">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    
                    <h1 class="success-title">Pengaduan Berhasil!</h1>
                    
                    @if(session('kode_pengaduan'))
                    <div class="success-code">
                        <h4>Kode Pengaduan Anda</h4>
                        <h2 class="mb-0" id="kodePengaduan">{{ session('kode_pengaduan') }}</h2>
                        <div class="mt-3">
                            <button class="btn btn-outline-primary btn-sm" onclick="copyKode()">
                                <i class="fas fa-copy mr-2"></i>Salin Kode
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="success-message">
                        <p class="mb-1">
                            <i class="fas fa-info-circle text-info mr-2"></i>
                            Terima kasih telah mengajukan pengaduan. Tim kami akan segera memproses laporan Anda.
                        </p>
                        <p class="text-muted small">
                            <i class="fas fa-envelope mr-2"></i>
                            Nomor pengaduan Anda akan dikirim melalui email yang telah didaftarkan.
                        </p>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('pelapor.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
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