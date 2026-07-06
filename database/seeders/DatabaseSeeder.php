<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KonfigurasiSeeder::class,
            KriteriaSeeder::class,
            PenggunaSeeder::class,
            NasabahHistorisSeeder::class,
            // Wajib SETELAH NasabahHistorisSeeder — meng-update 20 rekord
            // yang dibuatnya dengan komponen formulir asli (revisi tahap 4)
            HistoricalAnalisisSeeder::class,
        ]);
    }
}
