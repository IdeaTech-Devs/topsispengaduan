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
                                <th>Jenis Masalah</th>
                                <th>Tanggal Pengaduan</th>
                                <th>Fakultas</th>
                                <th>Urgensi</th>
                                <th>Tindak Lanjut</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasusProses as $kasus)
                                <tr>
                                    <td>{{ $kasus->kasus->no_pengaduan }}</td>
                                    <td>{{ ucfirst($kasus->kasus->jenis_masalah) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($kasus->kasus->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                    <td>{{ $kasus->kasus->asal_fakultas }}</td>
                                    <td>
                                        @switch($kasus->kasus->urgensi)
                                            @case('segera')
                                                <span class="badge badge-danger">Segera</span>
                                                @break
                                            @case('dalam beberapa hari')
                                                <span class="badge badge-warning">Beberapa Hari</span>
                                                @break
                                            @default
                                                <span class="badge badge-info">Tidak Mendesak</span>
                                        @endswitch
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($kasus->tanggal_tindak_lanjut)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('satgas.detail_kasus', $kasus->id_kasus) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <button type="button" 
                                                class="btn btn-success btn-sm"
                                                data-toggle="modal" 
                                                data-target="#selesaiModal{{ $kasus->id_kasus }}">
                                            <i class="fas fa-check"></i> Selesai
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Selesai -->
                                <div class="modal" id="selesaiModal{{ $kasus->id_kasus }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('satgas.update_status_kasus', $kasus->kasus->id_kasus) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_tindak_lanjut" value="selesai">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="penangan_kasus">Penangan Kasus</label>
                                                        <input type="text" class="form-control" name="penangan_kasus" 
                                                               value="{{ $satgas->nama }}" required>
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