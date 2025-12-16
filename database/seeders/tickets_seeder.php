<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class tickets_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $data = [
    //         [
    //             'id_user' => 1,
    //             'title' => 'Masalah pada sistem login',
    //             'description' => 'Saya tidak dapat masuk ke akun saya meskipun sudah memasukkan username dan password dengan benar.',
    //             'id_category' => 2,
    //             'attachment' => '',
    //             'status' => 'open',
    //             'admin_note' => '',
    //         ],
    //         [
    //             'id_user' => 2,
    //             'title' => 'Tidak bisa mengakses portal siswa',
    //             'description' => 'Saya mengalami kesulitan saat mencoba mengakses portal siswa. Setiap kali saya masuk, muncul pesan error.',
    //             'id_category' => 1,
    //             'attachment' => '',
    //             'status' => 'open',
    //             'admin_note' => '',
    //         ],
    //         [
    //             'id_user' => 3,
    //             'title' => 'Permintaan penambahan fitur baru',
    //             'description' => 'Saya ingin mengusulkan penambahan fitur baru pada sistem help desk untuk memudahkan pelaporan masalah.',
    //             'id_category' => 2,
    //             'attachment' => '',
    //             'status' => 'open',
    //             'admin_note' => '',
    //         ]
    //     ];
    //     DB::table('tickets')->insert($data);
    // }

     public function run()
    {
        $tickets = [];
        $now = Carbon::now();

        // daftar kategori (1–5)
        $categories = [1, 2, 3, 4, 5];
        $catIndex = 0;

        for ($userId = 1; $userId <= 20; $userId++) {

            // laporan 1
            $tickets[] = [
                'id_user' => $userId,
                'title' => 'Kendala sistem saat digunakan',
                'description' => 'Sistem mengalami kendala saat digunakan, fitur tidak berjalan dengan normal dan menghambat aktivitas pengguna.',
                'id_category' => $categories[$catIndex % 5],
                'attachment' => null,
                'admin_note' => null,
                'created_at' => $now,
            ];
            $catIndex++;

            // laporan 2
            $tickets[] = [
                'id_user' => $userId,
                'title' => 'Gangguan perangkat / jaringan',
                'description' => 'Terjadi gangguan pada perangkat atau koneksi jaringan sehingga aktivitas belajar atau kerja menjadi terganggu.',
                'id_category' => $categories[$catIndex % 5],
                'attachment' => null,
                'admin_note' => null,
                'created_at' => $now,
            ];
            $catIndex++;
        }

        DB::table('tickets')->insert($tickets);
    }

}
