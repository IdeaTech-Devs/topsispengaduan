@extends('pelapor.layout')

@section('title', 'Lihat Progress Pengaduan Fasilitas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg progress-check-card">
                <div class="progress-check-header">
                    <h3>
                        <i class="fas fa-search mr-2"></i>
                        Cek Progress Pengaduan Fasilitas
                    </h3>
                    <p>Masukkan kode pengaduan untuk melihat status laporan fasilitas Anda</p>
                </div>

                <div class="progress-check-form">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pengaduan.cek-status') }}" id="progressForm">
                        @csrf
                        <div class="form-group">
                            <input class="form-control kode-input @error('no_pengaduan') is-invalid @enderror" 
                                id="no_pengaduan" 
                                name="no_pengaduan" 
                                type="text" 
                                placeholder="Masukkan kode pengaduan"
                                pattern="[A-Z0-9]{6,}"
                                maxlength="20"
                                value="{{ old('no_pengaduan') }}"
                                required />
                            @error('no_pengaduan')
                                <div class="invalid-feedback text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-search mr-2"></i>Cek Progress
                            </button>
                        </div>
                    </form>

                    @if(session('status_pengaduan'))
                        <div class="alert alert-info text-center mt-4">
                            <strong>Status Pengaduan:</strong>
                            <span class="badge badge-{{
                                session('status_pengaduan') == 'selesai' ? 'success' :
                                (session('status_pengaduan') == 'proses satgas' ? 'primary' :
                                (session('status_pengaduan') == 'dikonfirmasi' ? 'info' :
                                (session('status_pengaduan') == 'ditolak' ? 'danger' : 'secondary')))
                            }}">
                                {{ ucfirst(session('status_pengaduan')) }}
                            </span>
                            <div class="mt-2">{{ session('status_keterangan') }}</div>
                        </div>
                    @endif

                    <div class="progress-info mt-4">
                        <div class="progress-info-item">
                            <i class="fas fa-info-circle"></i>
                            Kode pengaduan terdiri dari 6 karakter (huruf kapital dan angka)
                        </div>
                        <div class="progress-info-item">
                            <i class="fas fa-keyboard"></i>
                            Contoh format: ABC123
                        </div>
                        <div class="progress-info-item">
                            <i class="fas fa-envelope"></i>
                            Kode pengaduan telah dikirim ke email Anda
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Auto uppercase input
    $('#no_pengaduan').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });

    // Form validation with animation
    $('#progressForm').on('submit', function(e) {
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true);
        btn.html(`
            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
            Memeriksa...
        `);
    });
});
</script>
@endpush