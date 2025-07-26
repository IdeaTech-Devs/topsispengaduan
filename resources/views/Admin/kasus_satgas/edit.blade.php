@extends('admin.layout')

@section('title', 'Edit Penugasan Satgas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Pimpinan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kasus_satgas.update', [$kasusSatgas->id_kasus, $kasusSatgas->id_satgas]) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pelapor</label>
                            <input type="text" class="form-control"
                                   value="{{ $kasusSatgas->pelapor->nama }}"
                                   disabled>
                        </div>

                        <div class="form-group">
                            <label>Ruang</label>
                            <input type="text" class="form-control"
                                   value="{{ $kasusSatgas->ruang->nama }}"
                                   disabled>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_tindak_lanjut">Tanggal Tindak Lanjut <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_tindak_lanjut') is-invalid @enderror"
                                   id="tanggal_tindak_lanjut" name="tanggal_tindak_lanjut"
                                   value="{{ old('tanggal_tindak_lanjut', $kasusSatgas->tanggal_tindak_lanjut) }}"
                                   required>
                            @error('tanggal_tindak_lanjut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status_tindak_lanjut">Status Tindak Lanjut <span class="text-danger">*</span></label>
                            <select class="form-control @error('status_tindak_lanjut') is-invalid @enderror"
                                    id="status_tindak_lanjut" name="status_tindak_lanjut" required>
                                <option value="proses" {{ old('status_tindak_lanjut', $kasusSatgas->status_tindak_lanjut) == 'proses' ? 'selected' : '' }}>
                                    Proses
                                </option>
                                <option value="selesai" {{ old('status_tindak_lanjut', $kasusSatgas->status_tindak_lanjut) == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>
                            @error('status_tindak_lanjut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="tanggal_selesai_group">
                            <label for="tanggal_tindak_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tanggal_tindak_selesai') is-invalid @enderror"
                                   id="tanggal_tindak_selesai" name="tanggal_tindak_selesai"
                                   value="{{ old('tanggal_tindak_selesai', $kasusSatgas->tanggal_tindak_selesai) }}">
                            @error('tanggal_tindak_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.kasus_satgas.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

        // Trigger change event pada load
        $('#status_tindak_lanjut').trigger('change');
    });
</script>
@endpush
@endsection
