@extends('admin.layout')

@section('title', 'Tambah Penugasan Satgas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Penugasan Satgas</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kasus_satgas.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kasus">Kasus <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_kasus') is-invalid @enderror" 
                                    id="id_kasus" name="id_kasus" required>
                                <option value="">Pilih Kasus</option>
                                @foreach($kasus as $k)
                                    <option value="{{ $k->id_kasus }}" {{ old('id_kasus') == $k->id_kasus ? 'selected' : '' }}>
                                        {{ $k->no_pengaduan }} - {{ Str::limit($k->deskripsi_kasus, 50) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kasus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_satgas">Satgas <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_satgas') is-invalid @enderror" 
                                    id="id_satgas" name="id_satgas" required>
                                <option value="">Pilih Satgas</option>
                                @foreach($satgas as $s)
                                    <option value="{{ $s->id_satgas }}" {{ old('id_satgas') == $s->id_satgas ? 'selected' : '' }}>
                                        {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_satgas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_tindak_lanjut">Tanggal Tindak Lanjut <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_tindak_lanjut') is-invalid @enderror" 
                                   id="tanggal_tindak_lanjut" name="tanggal_tindak_lanjut" 
                                   value="{{ old('tanggal_tindak_lanjut', date('Y-m-d')) }}" required>
                            @error('tanggal_tindak_lanjut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status_tindak_lanjut">Status Tindak Lanjut <span class="text-danger">*</span></label>
                            <select class="form-control @error('status_tindak_lanjut') is-invalid @enderror" 
                                    id="status_tindak_lanjut" name="status_tindak_lanjut" required>
                                <option value="">Pilih Status</option>
                                <option value="proses" {{ old('status_tindak_lanjut') == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ old('status_tindak_lanjut') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status_tindak_lanjut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="tanggal_selesai_group" style="display: none;">
                            <label for="tanggal_tindak_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tanggal_tindak_selesai') is-invalid @enderror" 
                                   id="tanggal_tindak_selesai" name="tanggal_tindak_selesai" 
                                   value="{{ old('tanggal_tindak_selesai') }}">
                            @error('tanggal_tindak_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.kasus_satgas.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Tampilkan/sembunyikan field tanggal selesai berdasarkan status
        $('#status_tindak_lanjut').change(function() {
            if ($(this).val() === 'selesai') {
                $('#tanggal_selesai_group').show();
            } else {
                $('#tanggal_selesai_group').hide();
                $('#tanggal_tindak_selesai').val('');
            }
        });

        // Trigger change event pada load jika ada old value
        $('#status_tindak_lanjut').trigger('change');
    });
</script>
@endpush
@endsection 