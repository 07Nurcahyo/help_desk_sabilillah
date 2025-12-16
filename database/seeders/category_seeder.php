<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class category_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['category_name' => 'Hardware'],
            ['category_name' => 'Software'],
            ['category_name' => 'Networking'],
            ['category_name' => 'Security'],
            ['category_name' => 'Other'],
        ];

        DB::table('category')->insert($data);
    }
    
}
