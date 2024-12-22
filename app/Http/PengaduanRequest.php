<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengaduanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:100',
            'nama_panggilan' => 'nullable|string|max:50',
            'unsur' => 'required|in:dosen,mahasiswa,tenaga kependidikan,lainnya',
            'bukti_identitas' => 'required|file|max:2048|mimes:jpg,jpeg,png,pdf',
            'fakultas' => 'required|string|max:50',
            'departemen_prodi' => 'nullable|string|max:50',
            'unit_kerja' => 'nullable|string|max:50',
            'email' => 'required|email|max:100',
            'no_wa' => 'required|string|max:15',
            'hubungan_korban' => 'nullable|in:diri sendiri,teman,keluarga,lainnya',
            'jenis_masalah' => 'required|in:bullying,kekerasan seksual,pelecehan verbal,diskriminasi,cyberbullying,lainnya',
            'urgensi' => 'required|in:segera,dalam beberapa hari,tidak mendesak',
            'dampak' => 'required|in:sangat besar,sedang,kecil',
            'deskripsi_kasus' => 'required|string',
            'bukti_kasus' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf',
            'asal_fakultas' => 'required|string|max:50'
        ];
    }

    public function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'bukti_identitas.required' => 'Bukti identitas wajib diunggah',
            'email.required' => 'Email wajib diisi',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi',
            'jenis_masalah.required' => 'Jenis masalah wajib dipilih',
            'deskripsi_kasus.required' => 'Deskripsi kasus wajib diisi',
        ];
    }
}