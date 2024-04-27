<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\harian;
use App\Models\periode;
use App\Models\rekening;
use App\Models\target;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        rekening::create([
            "kode_rekening" => "41101.01",
            "nama_rekening" => "Pajak Hotel Bintang 1"
        ]);

        target::create([
            "rekening_id" => "1",
            "target" => 60500000,
            "periode_id" => 1
        ]);

        harian::create([
            "rekening_id" => "1",
            "via" => "Bendahara",
            "tanggal" => "2022-10-2",
            "jumlah" => 2000000
        ]);

        periode::create([
            "masa_berlaku_awal" => "2022-01-01",
            "masa_berlaku_akhir" => "2022-12-31",
        ]);
    }
}
