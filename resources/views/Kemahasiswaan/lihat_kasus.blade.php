@extends('kemahasiswaan.layout')

@section('title', 'Lihat Kasus')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Kasus - Fakultas {{ $kemahasiswaan->fakultas }}</h1>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stats-number">{{ $kasus->total() }}</div>
                <div class="stats-label">Total Kasus</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                @php
                    $highPriorityCount = collect($prioritasKasus)->filter(function($score) {
                        return $score >= 0.7;
                    })->count();
                @endphp
                <div class="stats-number">{{ $highPriorityCount }}</div>
                <div class="stats-label">Prioritas Tinggi</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-number">{{ $kasus->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                <div class="stats-label">Kasus Minggu Ini</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-number">{{ $kasus->where('status', 'selesai')->count() }}</div>
                <div class="stats-label">Kasus Selesai</div>
            </div>
        </div>
    </div>

    <!-- Quick Filter Buttons -->
    <div class="filter-buttons mb-4">
        <button class="filter-btn active" data-filter="all">
            <i class="fas fa-list"></i> Semua ({{ $kasus->total() }})
        </button>
        @php
            $highPriority = collect($prioritasKasus)->filter(function($score) {
                return $score >= 0.7;
            })->count();
            
            $mediumPriority = collect($prioritasKasus)->filter(function($score) {
                return $score >= 0.4 && $score < 0.7;
            })->count();
            
            $lowPriority = collect($prioritasKasus)->filter(function($score) {
                return $score < 0.4;
            })->count();
        @endphp
        <button class="filter-btn" data-filter="tinggi">
            <i class="fas fa-exclamation-circle"></i> Prioritas Tinggi ({{ $highPriority }})
        </button>
        <button class="filter-btn" data-filter="sedang">
            <i class="fas fa-exclamation"></i> Prioritas Sedang ({{ $mediumPriority }})
        </button>
        <button class="filter-btn" data-filter="rendah">
            <i class="fas fa-info-circle"></i> Prioritas Rendah ({{ $lowPriority }})
        </button>
    </div>

    <!-- Main Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kasus Yang Perlu Dievaluasi (Diurutkan berdasarkan Prioritas)</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pengaduan</th>
                            <th>Nama Pelapor</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Kriteria</th>
                            <th>Skor TOPSIS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasus as $k)
                            <tr class="priority-{{ strtolower($priorityText ?? 'normal') }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->kode_pengaduan }}</td>
                                <td>{{ $k->pelapor->nama_lengkap }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="kriteria-tags">
                                        @foreach($kriteria as $krit)
                                            @php
                                                $nilai = null;
                                                switch($krit->nama_kriteria) {
                                                    case 'jenis_masalah':
                                                        $nilai = ucfirst($k->jenis_masalah);
                                                        break;
                                                    case 'urgensi':
                                                        $nilai = ucfirst($k->urgensi);
                                                        break;
                                                    case 'dampak':
                                                        $nilai = ucfirst($k->dampak);
                                                        break;
                                                    case 'unsur':
                                                        $nilai = $k->pelapor ? ucfirst($k->pelapor->unsur) : '-';
                                                        break;
                                                    case 'bukti':
                                                        $nilai = $k->bukti_kasus ? 'Ada Bukti' : 'Tidak Ada Bukti';
                                                        break;
                                                }
                                                
                                                $nilaiKriteria = $krit->nilaiKriteria->where('item', strtolower($nilai))->first();
                                                $nilaiNumerik = $nilaiKriteria ? $nilaiKriteria->nilai : '-';
                                            @endphp
                                            
                                            <div class="mb-1">
                                                <strong>{{ ucwords(str_replace('_', ' ', $krit->nama_kriteria)) }}:</strong>
                                                <span class="badge badge-info">{{ $nilai }}</span>
                                                <small class="text-muted">({{ $nilaiNumerik }})</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $hasScore = isset($prioritasKasus[$k->id_kasus]);
                                        $rawScore = $hasScore ? $prioritasKasus[$k->id_kasus] : null;
                                        
                                        if ($hasScore) {
                                            // Konversi skor ke persentase yang lebih seimbang
                                            $displayScore = max(min(round($rawScore * 100), 100), 0);
                                            
                                            // Tentukan kategori prioritas
                                            if ($rawScore >= 0.7) {
                                                $scoreColor = 'bg-danger';
                                                $priorityText = 'Prioritas Tinggi';
                                            } elseif ($rawScore >= 0.4) {
                                                $scoreColor = 'bg-warning';
                                                $priorityText = 'Prioritas Sedang';
                                            } else {
                                                $scoreColor = 'bg-success';
                                                $priorityText = 'Prioritas Rendah';
                                            }
                                        }
                                    @endphp

                                    @if($hasScore)
                                        <div class="d-flex flex-column">
                                            <div class="progress mb-1" style="height: 20px;">
                                                <div class="progress-bar {{ $scoreColor }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $displayScore }}%"
                                                     aria-valuenow="{{ $displayScore }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $displayScore }}%
                                                </div>
                                            </div>
                                            <div class="small text-muted">
                                                {{ $priorityText }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Belum dihitung</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('kemahasiswaan.detail_kasus', $k->id_kasus) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-primary btn-sm"
                                                data-toggle="modal" 
                                                data-target="#evaluasiModal{{ $k->id_kasus }}"
                                                title="Evaluasi Kasus">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada kasus yang perlu dievaluasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination dengan style baru -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $kasus->firstItem() ?? 0 }} - {{ $kasus->lastItem() ?? 0 }} dari {{ $kasus->total() }} kasus
                </div>
                {{ $kasus->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<a href="#top" class="floating-action-btn" title="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
</a>

<!-- Modal di luar table loop -->
@foreach($kasus as $k)
    <div class="modal" id="evaluasiModal{{ $k->id_kasus }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Evaluasi</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('kemahasiswaan.evaluasi_kasus', $k->id_kasus) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin mengevaluasi kasus ini?</p>
                        <p class="mb-0">Kasus ini akan masuk ke daftar kelola kasus Anda.</p>
                        <small class="text-muted">Anda dapat menerima atau menolak kasus ini nanti di halaman kelola kasus.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ya, Evaluasi Kasus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection