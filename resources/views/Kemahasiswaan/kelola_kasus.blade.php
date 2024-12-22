@extends('kemahasiswaan.layout')

@section('title', 'Kelola Kasus')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Kasus - Fakultas {{ $kemahasiswaan->fakultas }}</h1>
    </div>

    <!-- Stats untuk Kelola Kasus -->
    <div class="verification-stats">
        <div class="verification-card">
            <div class="verification-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="verification-number">{{ $kasus->where('status_pengaduan', 'perlu dikonfirmasi')->count() }}</div>
            <div class="verification-label">Kasus Yang Perlu Diverifikasi</div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kasus Yang Perlu Diverifikasi</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                            <th>Email</th>
                            <th>No. WhatsApp</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Jenis Masalah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasus as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->kode_pengaduan }}</td>
                                <td>{{ $k->pelapor->nama_lengkap }}</td>
                                <td>
                                    <a href="mailto:{{ $k->pelapor->email }}" 
                                       class="btn btn-danger btn-sm contact-btn">
                                        <i class="far fa-envelope"></i> Email
                                    </a>
                                </td>
                                <td>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $k->pelapor->no_wa) }}" 
                                       target="_blank" 
                                       class="btn btn-success btn-sm contact-btn">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_pengaduan)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($k->jenis_masalah) }}</td>
                                <td>
                                    <span class="status-badge {{ strtolower($k->status_pengaduan) }}">
                                        {{ $k->status_pengaduan }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('kemahasiswaan.detail_kasus', $k->id_kasus) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($k->status_pengaduan == 'perlu dikonfirmasi')
                                    <button type="button" 
                                            class="btn btn-primary btn-sm"
                                            data-toggle="modal" 
                                            data-target="#verifikasiModal{{ $k->id_kasus }}">
                                        <i class="fas fa-check"></i> Verifikasi
                                    </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Verifikasi -->
                            <div class="modal fade" id="verifikasiModal{{ $k->id_kasus }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Verifikasi Kasus</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('kemahasiswaan.verifikasi_kasus', $k->id_kasus) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Status Verifikasi</label>
                                                    <select class="form-control" name="status" required>
                                                        <option value="dikonfirmasi">Terima Kasus</option>
                                                        <option value="ditolak">Tolak Kasus</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" rows="3" required 
                                                              placeholder="Berikan keterangan verifikasi..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada kasus yang perlu diverifikasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $kasus->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
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