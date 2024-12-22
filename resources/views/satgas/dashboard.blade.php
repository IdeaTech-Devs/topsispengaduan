@extends('satgas.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        
        <div class="welcome-message mb-4">
            <div class="alert alert-light border-left-primary">
                <i class="fas fa-user-shield mr-2"></i>
                Selamat datang di halaman dashboard Satgas, <strong>{{ $satgas->nama }}</strong>
            </div>
        </div>

        <!-- Basic Stats -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card stats-card proses" data-toggle="tooltip" title="Jumlah kasus yang sedang diproses">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-clock mr-2"></i>
                            Kasus Dalam Proses
                        </h5>
                        <p class="card-text" data-value="{{ $totalKasusProses }}">{{ $totalKasusProses }}</p>
                        <div class="icon-background">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stats-card selesai" data-toggle="tooltip" title="Jumlah kasus yang telah selesai">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-check-circle mr-2"></i>
                            Kasus Selesai
                        </h5>
                        <p class="card-text" data-value="{{ $totalKasusSelesai }}">{{ $totalKasusSelesai }}</p>
                        <div class="icon-background">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-bolt mr-2"></i>
                            Aksi Cepat
                        </h5>
                        <div class="btn-group" role="group">
                            <a href="{{ route('satgas.kasus_proses') }}" class="btn btn-primary mr-2">
                                <i class="fas fa-clock mr-1"></i>
                                Kasus Dalam Proses
                            </a>
                            <a href="{{ route('satgas.kasus_selesai') }}" class="btn btn-success">
                                <i class="fas fa-check-circle mr-1"></i>
                                Kasus Selesai
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection