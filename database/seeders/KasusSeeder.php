<?php

namespace Database\Seeders;

use App\Models\Kasus;
use App\Models\KasusSatgas;
use Illuminate\Database\Seeder;

class KasusSeeder extends Seeder
{
    public function run()
    {
        $kasus = [
            [
                'pelapor_id' => 1,
                'no_pengaduan' => 'FAC001',
                'judul_pengaduan' => 'AC Rusak di Ruang Kelas 301',
                'deskripsi' => 'AC di ruang kelas 301 tidak dingin dan mengeluarkan bunyi berisik',
                'lokasi_fasilitas' => 'Gedung A Lantai 3 Ruang 301',
                'jenis_fasilitas' => 'AC',
                'tingkat_urgensi' => 'Tinggi',
                'status' => 'Diproses',
                'foto_bukti' => 'ac_rusak.jpg',
                'tanggal_pengaduan' => '2024-03-15 09:00:00',
                'tanggal_penanganan' => '2024-03-15 10:00:00'
            ],
            [
                'pelapor_id' => 2,
                'no_pengaduan' => 'FAC002',
                'judul_pengaduan' => 'Kebocoran Atap Perpustakaan',
                'deskripsi' => 'Terjadi kebocoran atap di area baca perpustakaan lantai 2',
                'lokasi_fasilitas' => 'Perpustakaan Lantai 2',
                'jenis_fasilitas' => 'Atap',
                'tingkat_urgensi' => 'Tinggi',
                'status' => 'Selesai',
                'foto_bukti' => 'bocor_atap.jpg',
                'foto_penanganan' => 'perbaikan_atap.jpg',
                'tanggal_pengaduan' => '2024-03-14 13:00:00',
                'tanggal_penanganan' => '2024-03-14 14:00:00',
                'tanggal_selesai' => '2024-03-14 16:00:00'
            ],
            [
                'pelapor_id' => 3,
                'no_pengaduan' => 'FAC003',
                'judul_pengaduan' => 'Proyektor Tidak Berfungsi',
                'deskripsi' => 'Proyektor di ruang seminar tidak menampilkan gambar',
                'lokasi_fasilitas' => 'Ruang Seminar Lt.1',
                'jenis_fasilitas' => 'Proyektor',
                'tingkat_urgensi' => 'Sedang',
                'status' => 'Menunggu',
                'foto_bukti' => 'proyektor.jpg',
                'tanggal_pengaduan' => '2024-03-16 08:00:00'
            ]
        ];

        foreach ($kasus as $k) {
            Kasus::create($k);
        }

        // Seed kasus_satgas
        $kasusSatgas = [
            [
                'kasus_id' => 1,
                'satgas_id' => 1,
                'status_penanganan' => 'Sedang ditangani',
                'catatan_penanganan' => 'Sedang melakukan pengecekan unit AC',
                'mulai_penanganan' => '2024-03-15 10:00:00'
            ],
            [
                'kasus_id' => 2,
                'satgas_id' => 2,
                'status_penanganan' => 'Selesai',
                'catatan_penanganan' => 'Perbaikan atap telah selesai dilakukan',
                'mulai_penanganan' => '2024-03-14 14:00:00',
                'selesai_penanganan' => '2024-03-14 16:00:00'
            ]
        ];

        foreach ($kasusSatgas as $ks) {
            KasusSatgas::create($ks);
        }
    }
}
