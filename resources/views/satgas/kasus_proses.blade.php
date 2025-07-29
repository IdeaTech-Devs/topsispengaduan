@extends('satgas.layout')

@section('title', 'Kasus Dalam Proses')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Informasi Jumlah Kasus dalam bentuk Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Kasus yang Sedang Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusProses->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($kasusProses->isEmpty())
                <p class="text-center">Tidak ada kasus yang sedang dalam proses.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Pengaduan</th>
                                <th>Judul Pengaduan</th>
                                <th>Jenis Fasilitas</th>
                                <th>Tanggal Pengaduan</th>
                                <th>Pelapor</th>
                                <th>Urgensi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasusProses as $kasus)
                                <tr>
                                    <td>{{ $kasus->no_pengaduan }}</td>
                                    <td>{{ $kasus->judul_pengaduan }}</td>
                                    <td>{{ ucfirst($kasus->jenis_fasilitas) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($kasus->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                    <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                                    <td>
                                        @switch($kasus->tingkat_urgensi)
                                            @case('Tinggi')
                                                <span class="badge badge-danger">Tinggi</span>
                                                @break
                                            @case('Sedang')
                                                <span class="badge badge-warning">Sedang</span>
                                                @break
                                            @default
                                                <span class="badge badge-info">Rendah</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($kasus->status)
                                            @case('Menunggu')
                                                <span class="badge badge-warning">Menunggu</span>
                                                @break
                                            @case('Diproses')
                                                <span class="badge badge-primary">Diproses</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $kasus->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('satgas.detail_kasus', $kasus->id) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        @if($kasus->status != 'Selesai')
                                            <button type="button" 
                                                    class="btn btn-success btn-sm"
                                                    data-toggle="modal" 
                                                    data-target="#selesaiModal{{ $kasus->id }}">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Modal Selesai -->
                                <div class="modal" id="selesaiModal{{ $kasus->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('satgas.update_status_kasus', $kasus->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_tindak_lanjut" value="selesai">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="penangan_kasus">Penangan Kasus</label>
                                                        <input type="text" class="form-control" name="penangan_kasus" 
                                                               value="{{ $pimpinan->nama }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="catatan_penanganan">Catatan Penanganan</label>
                                                        <textarea class="form-control" name="catatan_penanganan" 
                                                                  rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Selesaikan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $kasusProses->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection 