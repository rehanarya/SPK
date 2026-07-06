<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nasabah;
use App\Models\Periode;
use App\Models\Pengajuan;
use App\Models\HasilPerhitungan;
use App\Services\WeightedProductService;

class NasabahHistorisSeeder extends Seeder
{
    /*
     * 20 data gold standard dari Tabel 3.1 RULES.md.
     * Urutan: [nama, C1_laba_usaha, C2_pendapatan_bersih, C3_nilai_agunan, C4_besar_pembiayaan, C5_jangka_waktu]
     * Status riil ditetapkan via θ = 250 (bootstrap §6.2 RULES.md).
     */
    private array $dataset = [
        ['Eky Setyoningsih', 6100000, 1600000, 2, 15000000, 24],
        ['Suharni',          7200000, 2100000, 4, 30000000, 36],
        ['Suradi',           5100000, 1100000, 3,  5000000, 12],
        ['Padi Irokromo',    7100000, 4200000, 4, 40000000, 24],
        ['Pardi',            3500000,  200000, 1,  1500000, 24],
        ['Budianto',         3000000, 2000000, 4,  2000000, 10],
        ['Samiyo',           2100000, 1650000, 4, 15000000, 24],
        ['Maryanto',         2000000, 2000000, 2,  5000000, 36],
        ['Supriyanto',       1700000,  300000, 1,  1500000, 15],
        ['Kasiman',          4500000, 1400000, 2, 10000000, 18],
        ['Timo',             2000000,  200000, 2,  2500000, 36],
        ['Parto',            4350000, 1500000, 4, 21500000, 36],
        ['Muladi',           8400000, 4900000, 4, 35000000, 18],
        ['Suyato',           9300000, 4700000, 3, 22000000, 12],
        ['Sutarti',          8100000, 1600000, 4, 15000000, 24],
        ['Padi',             3050000, 1100000, 4,  7000000, 18],
        ['Sugiyarto',        1800000,  500000, 2,  2000000, 12],
        ['Suparlan',         3400000,  600000, 4,  5000000, 24],
        ['Nariyadi',         6200000, 2700000, 2, 25000000, 24],
        ['Yanto',            4600000,  500000, 2,  4000000, 24],
    ];

    public function run(): void
    {
        // Periode historis demonstratif untuk 20 data seeder
        $periode = Periode::firstOrCreate(
            ['kode_periode' => '2024-HIST'],
            [
                'tanggal_mulai'   => '2024-01-01',
                'tanggal_selesai' => '2024-01-07',
                'status'          => 'tutup',
                'created_at'      => now(),
            ]
        );

        $wpService = app(WeightedProductService::class);
        $threshold = 250.0;

        // Insert nasabah + pengajuan
        $pengajuanList = [];
        foreach ($this->dataset as $i => $row) {
            [$nama, $c1, $c2, $c3, $c4, $c5] = $row;

            $noAnggota = 'HST-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);

            $nasabah = Nasabah::firstOrCreate(
                ['no_anggota' => $noAnggota],
                [
                    'nama_nasabah' => $nama,
                    'alamat'       => 'Girimarto, Wonogiri',
                    'no_telp'      => null,
                    'jenis_usaha'  => 'Usaha Mikro',
                ]
            );

            $pengajuan = Pengajuan::firstOrCreate(
                ['id_nasabah' => $nasabah->id_nasabah, 'id_periode' => $periode->id_periode],
                [
                    'C1_laba_usaha'        => $c1,
                    'C2_pendapatan_bersih' => $c2,
                    'C3_nilai_agunan'      => $c3,
                    'C4_besar_pembiayaan'  => $c4,
                    'C5_jangka_waktu'      => $c5,
                    'tanggal_pengajuan'    => '2024-01-03',
                ]
            );

            $pengajuanList[] = $pengajuan;
        }

        // Hitung vektor S dan V untuk seluruh periode
        $hasil = $wpService->hitungPeriode($pengajuanList);

        foreach ($hasil as $item) {
            $status = $item['vektor_S'] >= $threshold ? 'diterima' : 'ditolak';

            HasilPerhitungan::updateOrCreate(
                ['id_pengajuan' => $item['id_pengajuan']],
                [
                    'vektor_S'   => $item['vektor_S'],
                    'vektor_V'   => $item['vektor_V'],
                    'ranking'    => $item['ranking'],
                    'status'     => $status,
                    'created_at' => now(),
                ]
            );
        }
    }
}
