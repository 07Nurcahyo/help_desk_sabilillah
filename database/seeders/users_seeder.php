<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class users_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $data = [
            // [
            //     'id_user' => 1,
            //     'name' => 'PROF. Dr. Anton Santoso, S.Kom',
            //     'username' => 'anton',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'admin',
            // ],
            // [
            //     'id_user' => 2,
            //     'name' => 'Dr. Rina Hartati, S.Kom',
            //     'username' => 'rina',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'admin',
            // ],
            // [
            //     'id_user' => 3,
            //     'name' => 'BUDI SANTOSO, m.PD',
            //     'username' => 'budi',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 4,
            //     'name' => 'Citra Dewi, M.Pd',
            //     'username' => 'citra',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 5,
            //     'name' => 'Dewi Lestari, S.Kom',
            //     'username' => 'dewi',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 6,
            //     'name' => 'Eko Prasetyo, AMd.Gz',
            //     'username' => 'eko',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 7,
            //     'name' => 'fajar nugroho, s.Pd',
            //     'username' => 'fajar',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 8,
            //     'name' => 'GITA PRAMESTI, s.tr.Kom',
            //     'username' => 'gita',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 9,
            //     'name' => 'Hadi Susanto',
            //     'username' => 'hadi',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 10,
            //     'name' => 'Indah Wulandari, M.Si',
            //     'username' => 'indah',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            // [
            //     'id_user' => 11,
            //     'name' => 'JOKO SANTOSO',
            //     'username' => 'joko',
            //     'password' => bcrypt('testProgrammer'),
            //     'status' => 'active',
            //     'role' => 'guru',
            // ],
            [
                'id_user' => 12,
                'name' => 'DEWI LESTARI',
                'username' => 'dewi_siswa',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
            [
                'id_user' => 13,
                'name' => 'eko prasetyo',
                'username' => 'eko_siswa',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
            [
                'id_user' => 14,
                'name' => 'Fajar Nugroho',
                'username' => 'fajar_siswa',
                'password' => bcrypt('testProgrammer'),
                'status' => 'inactive',
                'role' => 'siswa',
            ],
            [
                'id_user' => 15,
                'name' => 'gina saputra',
                'username' => 'gina',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
            [
                'id_user' => 16,
                'name' => 'HADI SUSANTO',
                'username' => 'hadi_siswa',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
            [
                'id_user' => 17,
                'name' => 'Indah wulandari',
                'username' => 'indah_siswa',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
            [
                'id_user' => 18,
                'name' => 'Joko Santoso',
                'username' => 'joko_siswa',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
            [
                'id_user' => 19,
                'name' => 'Kiki Maharani',
                'username' => 'kiki',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
            [
                'id_user' => 20,
                'name' => 'lina dewi',
                'username' => 'lina',
                'password' => bcrypt('testProgrammer'),
                'status' => 'active',
                'role' => 'siswa',
            ],
        ];

        DB::table('users')->insert($data);

        
    }
}
