@extends('kemahasiswaan.layout')

@section('title', 'Kasus dikonfirmasi')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="case-stats">
        <div class="case-card confirmed">
            <div class="case-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="case-number">{{ $kasusKonfirmasi->count() }}</div>
            <div class="case-label">Kasus Dikonfirmasi</div>
        </div>
        <div class="case-card rejected">
            <div class="case-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="case-number">{{ $kasusDitolak->count() }}</div>
            <div class="case-label">Kasus Ditolak</div>
        </div>
    </div>

    <!-- Kasus Dikonfirmasi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 confirmed">
            <h6 class="m-0 font-weight-bold text-success">Daftar Kasus Yang Dikonfirmasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableKonfirmasi" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pengaduan</th>
                            <th>Nama Pelapor</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Jenis Masalah</th>
                            <th>Tanggal Konfirmasi</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasusKonfirmasi as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->kode_pengaduan }}</td>
                                <td>{{ $k->pelapor->nama_lengkap }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($k->jenis_masalah) }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_konfirmasi)->format('d/m/Y') }}</td>
                                <td>{{ $k->catatan_penanganan }}</td>
                                <td>
                                    <a href="{{ route('kemahasiswaan.detail_kasus', $k->id_kasus) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada kasus yang dikonfirmasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kasus Ditolak -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 rejected">
            <h6 class="m-0 font-weight-bold text-danger">Daftar Kasus Yang Ditolak</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableDitolak" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pengaduan</th>
                            <th>Nama Pelapor</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Jenis Masalah</th>
                            <th>Alasan Penolakan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasusDitolak as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->kode_pengaduan }}</td>
                                <td>{{ $k->pelapor->nama_lengkap }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($k->jenis_masalah) }}</td>
                                <td>{{ $k->catatan_penanganan }}</td>
                                <td>
                                    <a href="{{ route('kemahasiswaan.detail_kasus', $k->id_kasus) }}" 
                                       class="btn btn-info btn-sm mb-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <button type="button" 
                                            class="btn btn-warning btn-sm"
                                            data-toggle="modal" 
                                            data-target="#evaluasiUlangModal{{ $k->id_kasus }}">
                                        <i class="fas fa-redo"></i> Evaluasi Ulang
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Evaluasi Ulang -->
                            <div class="modal fade" id="evaluasiUlangModal{{ $k->id_kasus }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Evaluasi Ulang Kasus</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('kemahasiswaan.evaluasi_ulang', $k->id_kasus) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin mengevaluasi ulang kasus ini?</p>
                                                <div class="form-group">
                                                    <label>Catatan Evaluasi Ulang</label>
                                                    <textarea class="form-control" name="catatan" rows="3" required 
                                                              placeholder="Berikan alasan evaluasi ulang..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-warning">Evaluasi Ulang</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada kasus yang ditolak</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tableKonfirmasi, #tableDitolak').DataTable({
            "pageLength": 10,
            "ordering": true,
            "info": true,
            "searching": true,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush
@endsection
