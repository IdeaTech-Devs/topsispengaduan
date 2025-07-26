@extends('admin.layout')

@section('title', 'Kasus Belum Selesai')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah Kasus Belum Selesai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusBelumSelesai->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kasus Belum Selesai</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pengaduan</th>
                        <th>Nama Pelapor</th>
                        <th>Jenis Masalah</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kasusBelumSelesai as $kasus)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kasus->no_pengaduan }}</td>
                        <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                        <td>{{ $kasus->jenis_masalah }}</td>
                        <td>
                            @if($kasus->satgas->count() > 0)
                                @foreach($kasus->satgas as $satgas)
                                    <span class="badge badge-info">{{ $satgas->nama }}</span>
                                @endforeach
                            @else
                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#pilihPetugasModal{{ $kasus->id_kasus }}">
                                    Pilih Petugas
                                </button>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{
                                $kasus->status_pengaduan == 'dikonfirmasi' ? 'primary' :
                                ($kasus->status_pengaduan == 'proses pimpinan' ? 'info' : 'warning')
                            }}">
                                {{ ucfirst($kasus->status_pengaduan) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.tindak_lanjut.detail', ['id' => $kasus->id_kasus]) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($kasus->status_pengaduan == 'proses pimpinan')
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#selesaiModal{{ $kasus->id_kasus }}">
                                    <i class="fas fa-check"></i> Selesai
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Pilih Petugas -->
@foreach($kasusBelumSelesai as $kasus)
<div class="modal fade" id="pilihPetugasModal{{ $kasus->id_kasus }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Petugas Pimpinan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tindak_lanjut.assign_satgas', $kasus->id_kasus) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Nama Pimpinan</th>
                                    <th>Fakultas</th>
                                    <th>Kasus Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($satgasList as $satgas)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="satgas_ids[]"
                                               value="{{ $satgas->id_satgas }}"
                                               class="form-check-input">
                                    </td>
                                    <td>{{ $satgas->nama }}</td>
                                    <td>{{ $satgas->fakultas }}</td>
                                    <td>
                                        {{ $satgas->kasus_aktif_count }} kasus aktif
                                        @if($satgas->kasus_aktif_count > 0)
                                            <button type="button" class="btn btn-sm btn-info ml-2"
                                                    data-toggle="popover"
                                                    title="Kasus yang Ditangani"
                                                    data-content="{{ $satgas->kasus_aktif_list }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan & Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Selesai -->
@foreach($kasusBelumSelesai as $kasus)
<div class="modal fade" id="selesaiModal{{ $kasus->id_kasus }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Selesaikan Kasus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tindak_lanjut.update_status', $kasus->id_kasus) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status_pengaduan" value="selesai">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="penangan_kasus">Penangan Kasus</label>
                        <input type="text" class="form-control" name="penangan_kasus"
                               value="{{ $kasus->penangan_kasus }}" required>
                    </div>
                    <div class="form-group">
                        <label for="catatan_penanganan">Catatan Penanganan</label>
                        <textarea class="form-control" name="catatan_penanganan"
                                  rows="3" required>{{ $kasus->catatan_penanganan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Selesaikan Kasus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        // Inisialisasi popover
        $('[data-toggle="popover"]').popover({
            trigger: 'hover',
            placement: 'top'
        });
    });
</script>
@endpush
