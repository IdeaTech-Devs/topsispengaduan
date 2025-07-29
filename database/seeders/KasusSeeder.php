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
            ],
            [
                'pelapor_id' => 4,
                'no_pengaduan' => 'FAC004',
                'judul_pengaduan' => 'Lampu Mati di Koridor',
                'deskripsi' => 'Beberapa lampu di koridor gedung B tidak menyala',
                'lokasi_fasilitas' => 'Gedung B Koridor Lantai 2',
                'jenis_fasilitas' => 'Lampu',
                'tingkat_urgensi' => 'Sedang',
                'status' => 'Diproses',
                'foto_bukti' => 'lampu_mati.jpg',
                'tanggal_pengaduan' => '2024-03-17 10:00:00',
                'tanggal_penanganan' => '2024-03-17 11:00:00'
            ],
            [
                'pelapor_id' => 5,
                'no_pengaduan' => 'FAC005',
                'judul_pengaduan' => 'Kran Air Bocor',
                'deskripsi' => 'Kran air di toilet gedung C mengeluarkan air terus menerus',
                'lokasi_fasilitas' => 'Gedung C Toilet Lantai 1',
                'jenis_fasilitas' => 'Plumbing',
                'tingkat_urgensi' => 'Tinggi',
                'status' => 'Selesai',
                'foto_bukti' => 'kran_bocor.jpg',
                'foto_penanganan' => 'perbaikan_kran.jpg',
                'tanggal_pengaduan' => '2024-03-13 15:00:00',
                'tanggal_penanganan' => '2024-03-13 16:00:00',
                'tanggal_selesai' => '2024-03-13 18:00:00'
            ]
        ];

        foreach ($kasus as $k) {
            Kasus::create($k);
        }

        // Seed kasus_satgas - menghubungkan kasus dengan berbagai satgas
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
            ],
            [
                'kasus_id' => 3,
                'satgas_id' => 3,
                'status_penanganan' => 'Belum ditangani',
                'catatan_penanganan' => null,
                'mulai_penanganan' => null
            ],
            [
                'kasus_id' => 4,
                'satgas_id' => 4,
                'status_penanganan' => 'Sedang ditangani',
                'catatan_penanganan' => 'Sedang mengganti lampu yang rusak',
                'mulai_penanganan' => '2024-03-17 11:00:00'
            ],
            [
                'kasus_id' => 5,
                'satgas_id' => 5,
                'status_penanganan' => 'Selesai',
                'catatan_penanganan' => 'Kran air telah diperbaiki dan tidak bocor lagi',
                'mulai_penanganan' => '2024-03-13 16:00:00',
                'selesai_penanganan' => '2024-03-13 18:00:00'
            ],
            // Tambahan untuk memastikan setiap satgas memiliki kasus
            [
                'kasus_id' => 1,
                'satgas_id' => 6,
                'status_penanganan' => 'Belum ditangani',
                'catatan_penanganan' => null,
                'mulai_penanganan' => null
            ],
            [
                'kasus_id' => 2,
                'satgas_id' => 7,
                'status_penanganan' => 'Selesai',
                'catatan_penanganan' => 'Pekerjaan telah selesai',
                'mulai_penanganan' => '2024-03-14 14:00:00',
                'selesai_penanganan' => '2024-03-14 16:00:00'
            ],
            [
                'kasus_id' => 3,
                'satgas_id' => 8,
                'status_penanganan' => 'Sedang ditangani',
                'catatan_penanganan' => 'Sedang memperbaiki proyektor',
                'mulai_penanganan' => '2024-03-16 09:00:00'
            ],
            [
                'kasus_id' => 4,
                'satgas_id' => 9,
                'status_penanganan' => 'Selesai',
                'catatan_penanganan' => 'Lampu telah diganti',
                'mulai_penanganan' => '2024-03-17 11:00:00',
                'selesai_penanganan' => '2024-03-17 13:00:00'
            ],
            [
                'kasus_id' => 5,
                'satgas_id' => 10,
                'status_penanganan' => 'Selesai',
                'catatan_penanganan' => 'Kran telah diperbaiki',
                'mulai_penanganan' => '2024-03-13 16:00:00',
                'selesai_penanganan' => '2024-03-13 18:00:00'
            ]
        ];

        foreach ($kasusSatgas as $ks) {
            KasusSatgas::create($ks);
        }
    }
}
