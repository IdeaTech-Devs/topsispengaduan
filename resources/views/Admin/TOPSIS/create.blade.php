@extends('admin.layout')

@section('title', 'Tambah Kriteria TOPSIS')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Kriteria TOPSIS</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.topsis.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_kriteria">Nama Kriteria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                                   id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria') }}" 
                                   required>
                            @error('nama_kriteria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bobot">Bobot (0-1) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" max="1" 
                                   class="form-control @error('bobot') is-invalid @enderror" 
                                   id="bobot" name="bobot" value="{{ old('bobot') }}" 
                                   required>
                            @error('bobot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis">Jenis <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis') is-invalid @enderror" 
                                    id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis</option>
                                <option value="benefit" {{ old('jenis') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                <option value="cost" {{ old('jenis') == 'cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="font-weight-bold">Nilai Kriteria</h6>
                <div class="nilai-kriteria-container">
                    @if(old('nilai_kriteria'))
                        @foreach(old('nilai_kriteria') as $index => $nilai)
                        <div class="row nilai-kriteria-item mb-3">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Item</label>
                                    <input type="text" class="form-control" 
                                           name="nilai_kriteria[{{ $index }}][item]" 
                                           value="{{ $nilai['item'] }}" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Nilai</label>
                                    <input type="number" class="form-control" 
                                           name="nilai_kriteria[{{ $index }}][nilai]" 
                                           value="{{ $nilai['nilai'] }}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger hapus-nilai">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                <button type="button" class="btn btn-success mb-3" id="tambah-nilai">
                    <i class="fas fa-plus"></i> Tambah Nilai Kriteria
                </button>

                <div class="text-right">
                    <a href="{{ route('admin.topsis.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Template untuk item nilai kriteria baru
    function getNilaiTemplate(index) {
        return `
            <div class="row nilai-kriteria-item mb-3">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Item</label>
                        <input type="text" class="form-control" 
                               name="nilai_kriteria[${index}][item]" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Nilai</label>
                        <input type="number" class="form-control" 
                               name="nilai_kriteria[${index}][nilai]" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="d-block">&nbsp;</label>
                    <button type="button" class="btn btn-danger hapus-nilai">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }

    // Tambah nilai kriteria
    $('#tambah-nilai').click(function() {
        let index = $('.nilai-kriteria-item').length;
        $('.nilai-kriteria-container').append(getNilaiTemplate(index));
    });

    // Hapus nilai kriteria
    $(document).on('click', '.hapus-nilai', function() {
        $(this).closest('.nilai-kriteria-item').remove();
    });
});
</script>
@endpush
@endsection 