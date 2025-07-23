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
            'status_pelapor' => 'required|in:staff,pengunjung',
            'email' => 'required|email|max:100',
            'no_wa' => 'required|string|max:15',
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi_fasilitas' => 'required|string|max:255',
            'jenis_fasilitas' => 'required|string|max:255',
            'tingkat_urgensi' => 'required|string|max:255',
            'foto_bukti' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf'
        ];
    }

    public function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi',
            'judul_pengaduan.required' => 'Judul pengaduan wajib diisi',
            'deskripsi.required' => 'Deskripsi pengaduan wajib diisi',
            'lokasi_fasilitas.required' => 'Lokasi fasilitas wajib diisi',
            'jenis_fasilitas.required' => 'Jenis fasilitas wajib diisi',
            'tingkat_urgensi.required' => 'Tingkat urgensi wajib diisi',
        ];
    }
}