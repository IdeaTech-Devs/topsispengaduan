@extends('admin.layout')

@section('title', 'Detail Pelapor')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data Pelapor</h6>
            <div>
                <a href="{{ route('admin.pelapor.edit', $pelapor->id_pelapor) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.pelapor.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama Lengkap</th>
                            <td>{{ $pelapor->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Nama Panggilan</th>
                            <td>{{ $pelapor->nama_panggilan }}</td>
                        </tr>
                        <tr>
                            <th>Unsur</th>
                            <td>
                                <span class="badge badge-{{ 
                                    $pelapor->unsur === 'dosen' ? 'primary' : 
                                    ($pelapor->unsur === 'mahasiswa' ? 'success' : 
                                    ($pelapor->unsur === 'tenaga kependidikan' ? 'info' : 'secondary')) 
                                }}">
                                    {{ ucfirst($pelapor->unsur) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Melapor Sebagai</th>
                            <td>
                                <span class="badge badge-{{ 
                                    $pelapor->melapor_sebagai === 'korban' ? 'danger' : 
                                    ($pelapor->melapor_sebagai === 'saksi' ? 'info' : 'secondary') 
                                }}">
                                    {{ ucfirst($pelapor->melapor_sebagai) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Bukti Identitas</th>
                            <td>
                                @if($pelapor->bukti_identitas)
                                    <a href="{{ Storage::url($pelapor->bukti_identitas) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-file"></i> Lihat File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fakultas</th>
                            <td>{{ $pelapor->fakultas }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Departemen/Prodi</th>
                            <td>{{ $pelapor->departemen_prodi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Unit Kerja</th>
                            <td>{{ $pelapor->unit_kerja ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <a href="mailto:{{ $pelapor->email }}" class="text-decoration-none">
                                    {{ $pelapor->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Nomor WhatsApp</th>
                            <td>
                                <a href="https://wa.me/{{ $pelapor->no_wa }}" 
                                   target="_blank" 
                                   class="text-decoration-none">
                                    {{ $pelapor->no_wa }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Hubungan dengan Korban</th>
                            <td>{{ $pelapor->hubungan_korban ? ucfirst($pelapor->hubungan_korban) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $pelapor->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $pelapor->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 