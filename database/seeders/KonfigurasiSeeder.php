<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konfigurasi;

class KonfigurasiSeeder extends Seeder
{
    public function run(): void
    {
        $params = [
            [
                'kunci'     => 'threshold_default',
                'nilai'     => '250',
                'deskripsi' => 'Ambang batas klasifikasi θ: S_i ≥ θ → Diterima. §5.1 RULES.md',
            ],
            [
                'kunci'     => 'top_n_prioritas',
                'nilai'     => '5',
                'deskripsi' => 'Jumlah nasabah teratas V_i yang ditandai Diprioritaskan per periode. §5.2 RULES.md',
            ],
            [
                'kunci'     => 'akurasi_minimum_loocv',
                'nilai'     => '90',
                'deskripsi' => 'Persentase akurasi LOOCV minimum sebelum rekalibrasi θ ditawarkan. §5.4 RULES.md',
            ],
        ];

        foreach ($params as $param) {
            Konfigurasi::updateOrCreate(['kunci' => $param['kunci']], $param);
        }
    }
}
