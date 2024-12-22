@extends('kemahasiswaan.layout')

@section('title', 'Dashboard Kemahasiswaan')

@section('content')
<!-- Welcome Banner -->
<div class="welcome-section mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h2 class="welcome-title">Selamat Datang, {{ $kemahasiswaan->nama }}</h2>
            <p class="welcome-subtitle">Panel Kontrol Kemahasiswaan - Satgas UNIB</p>
        </div>
        <div class="col-lg-4">
            <div class="quick-stats text-right">
                <div class="stats-item">
                    <i class="fas fa-clock"></i>
                    <span id="current-time">Loading...</span>
                </div>
                <div class="stats-item">
                    <i class="fas fa-calendar"></i>
                    <span id="current-date">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="dashboard-card pending border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Verifikasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="dashboard-card process border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Dalam Proses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $process_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cog fa-spin fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="dashboard-card completed border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Kasus Selesai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completed_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="dashboard-card total border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Kasus</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Cases -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Kasus Terbaru Yang Perlu Diverifikasi</h6>
                <a href="{{ route('kemahasiswaan.lihat_kasus') }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-arrow-right fa-sm"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="recent-cases-list">
                    @forelse($recent_cases as $case)
                    <div class="case-item">
                        <div class="case-info">
                            <h6>{{ $case->kode_pengaduan }} - {{ $case->judul }}</h6>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-user mr-1"></i> {{ $case->pelapor->nama_lengkap }} |
                                <i class="fas fa-calendar-alt mr-1"></i> 
                                {{ \Carbon\Carbon::parse($case->created_at)->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div class="case-status">
                            <span class="badge badge-{{ $case->status_class }}">
                                {{ $case->status_pengaduan }}
                            </span>
                        </div>
                        <a href="{{ route('kemahasiswaan.detail_kasus', ['id' => $case->id_kasus]) }}" 
                           class="stretched-link"></a>
                    </div>
                    @empty
                    <div class="text-center py-3">
                        <img src="{{ asset('assets/img/empty.svg') }}" alt="No Data" class="empty-image">
                        <p class="text-muted mt-2">Belum ada kasus yang perlu diverifikasi</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById('current-time');
        const dateElement = document.getElementById('current-date');
        
        timeElement.textContent = now.toLocaleTimeString('id-ID');
        dateElement.textContent = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    updateTime();
    setInterval(updateTime, 1000);
</script>
@endpush
