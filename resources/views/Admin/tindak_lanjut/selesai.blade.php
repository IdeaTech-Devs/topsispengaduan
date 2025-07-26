@extends('admin.layout')

@section('title', 'Kasus Selesai')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Kasus Selesai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kasusSelesai->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kasus Selesai</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pengaduan</th>
                        <th>Nama Lengkap</th>
                        <th>Unsur</th>
                        <th>Jenis Masalah</th>
                        <th>Kemahasiswaan</th>
                        <th>Fakultas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kasusSelesai as $kasus)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kasus->no_pengaduan }}</td>
                        <td>{{ $kasus->pelapor->nama_lengkap }}</td>
                        <td>{{ $kasus->pelapor->unsur }}</td>
                        <td>{{ $kasus->jenis_masalah }}</td>
                        <td>{{ $kasus->kemahasiswaan->nama }}</td>
                        <td>{{ $kasus->asal_fakultas }}</td>
                        <td>
                            <a href="{{ route('admin.tindak_lanjut.detail', ['id' => $kasus->id_kasus]) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" 
                                    data-target="#prosesUlangModal{{ $kasus->id_kasus }}">
                                <i class="fas fa-redo"></i> Proses Ulang
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Proses Ulang -->
@foreach($kasusSelesai as $kasus)
    <div class="modal fade" id="prosesUlangModal{{ $kasus->id_kasus }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proses Ulang Kasus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.tindak_lanjut.update_status', $kasus->id_kasus) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="Diproses">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin memproses ulang kasus ini?</p>
                        <p><strong>Kode Pengaduan:</strong> {{ $kasus->no_pengaduan }}</p>
                        <div class="form-group">
                            <label for="catatan_penanganan">Catatan Proses Ulang</label>
                            <textarea class="form-control" name="catatan_penanganan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Proses Ulang</button>
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
    });
</script>
@endpush 