<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class tickets_seeder extends Seeder
{
    public function run()
    {
        $tickets = [];

        $userIds   = DB::table('users')->pluck('id_user')->toArray();
        $categories = [1, 2, 3, 4, 5];
        $statuses   = ['baru', 'proses', 'selesai'];

        // loop 30 hari terakhir
        for ($day = 29; $day >= 0; $day--) {

            $date = Carbon::now()->subDays($day);

            // jumlah laporan per hari (biar naik turun)
            $jumlahLaporan = rand(0, 5);

            for ($i = 0; $i < $jumlahLaporan; $i++) {

                $tickets[] = [
                    'id_user'      => $userIds[array_rand($userIds)],
                    'title'        => 'Laporan harian sistem',
                    'description'  => 'Laporan otomatis untuk kebutuhan visualisasi grafik.',
                    'id_category'  => $categories[array_rand($categories)],
                    'attachment'   => null,
                    'status'       => $statuses[array_rand($statuses)],
                    'admin_note'   => null,
                    'created_at'   => $date
                                        ->copy()
                                        ->addHours(rand(8, 17))
                                        ->addMinutes(rand(0, 59)),
                    'updated_at'   => $date,
                ];
            }
        }

        DB::table('tickets')->insert($tickets);
    }
}
