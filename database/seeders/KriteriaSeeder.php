<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Bobot default 5-4-4-2-2, total = 17.
         * Normalisasi: w_j = (s_j × W_j) / Σ|W_j|
         * s_j = +1 benefit, -1 cost
         * Presisi sesuai §4.2 RULES.md
         */
        $total = 17;

        $kriteria = [
            [
                'kode_kriteria'     => 'C1',
                'nama_kriteria'     => 'Laba Usaha',
                'bobot_mentah'      => 5,
                'bobot_normalisasi' => round((1 * 5) / $total, 6),   // +0.294118
                'tipe'              => 'benefit',
                'satuan'            => 'rupiah',
            ],
            [
                'kode_kriteria'     => 'C2',
                'nama_kriteria'     => 'Pendapatan Bersih',
                'bobot_mentah'      => 4,
                'bobot_normalisasi' => round((1 * 4) / $total, 6),   // +0.235294
                'tipe'              => 'benefit',
                'satuan'            => 'rupiah',
            ],
            [
                'kode_kriteria'     => 'C3',
                'nama_kriteria'     => 'Nilai Agunan',
                'bobot_mentah'      => 4,
                'bobot_normalisasi' => round((1 * 4) / $total, 6),   // +0.235294
                'tipe'              => 'benefit',
                'satuan'            => 'ordinal',
            ],
            [
                'kode_kriteria'     => 'C4',
                'nama_kriteria'     => 'Besar Pembiayaan',
                'bobot_mentah'      => 2,
                'bobot_normalisasi' => round((-1 * 2) / $total, 6),  // -0.117647
                'tipe'              => 'cost',
                'satuan'            => 'rupiah',
            ],
            [
                'kode_kriteria'     => 'C5',
                'nama_kriteria'     => 'Jangka Waktu',
                'bobot_mentah'      => 2,
                'bobot_normalisasi' => round((-1 * 2) / $total, 6),  // -0.117647
                'tipe'              => 'cost',
                'satuan'            => 'bulan',
            ],
        ];

        foreach ($kriteria as $data) {
            Kriteria::updateOrCreate(['kode_kriteria' => $data['kode_kriteria']], $data);
        }
    }
}
