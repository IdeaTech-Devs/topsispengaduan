@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" minlength="8">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Minimal 8 karakter</small>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" minlength="8">
                        </div>

                        <div class="form-group">
                            <label for="role">Role <span class="text-danger">*</span></label>
                            <select class="form-control @error('role') is-invalid @enderror" 
                                    id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kemahasiswaan" {{ old('role', $user->role) == 'kemahasiswaan' ? 'selected' : '' }}>Kemahasiswaan</option>
                                <option value="satgas" {{ old('role', $user->role) == 'satgas' ? 'selected' : '' }}>Satgas</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="kemahasiswaan_section" style="display: none;">
                            <label for="id_kemahasiswaan">Pilih Kemahasiswaan <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_kemahasiswaan') is-invalid @enderror" 
                                    id="id_kemahasiswaan" name="id_kemahasiswaan">
                                <option value="">Pilih Kemahasiswaan</option>
                                @foreach($kemahasiswaan as $k)
                                    <option value="{{ $k->id_kemahasiswaan }}" 
                                            {{ old('id_kemahasiswaan', $user->id_kemahasiswaan) == $k->id_kemahasiswaan ? 'selected' : '' }}>
                                        {{ $k->nama }} - {{ $k->fakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kemahasiswaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="satgas_section" style="display: none;">
                            <label for="id_satgas">Pilih Satgas <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_satgas') is-invalid @enderror" 
                                    id="id_satgas" name="id_satgas">
                                <option value="">Pilih Satgas</option>
                                @foreach($satgas as $s)
                                    <option value="{{ $s->id_satgas }}" 
                                            {{ old('id_satgas', $user->id_satgas) == $s->id_satgas ? 'selected' : '' }}>
                                        {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_satgas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    function toggleFields() {
        var role = $('#role').val();
        
        if (role === 'kemahasiswaan') {
            $('#kemahasiswaan_section').show();
            $('#satgas_section').hide();
            $('#id_satgas').val('');
        } else if (role === 'satgas') {
            $('#kemahasiswaan_section').hide();
            $('#satgas_section').show();
            $('#id_kemahasiswaan').val('');
        } else {
            $('#kemahasiswaan_section').hide();
            $('#satgas_section').hide();
            $('#id_kemahasiswaan').val('');
            $('#id_satgas').val('');
        }
    }

    toggleFields();
    $('#role').change(toggleFields);
});
</script>
@endpush
@endsection 