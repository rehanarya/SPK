<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = [
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'nama'     => 'Administrator KSPPS',
                'peran'    => 'admin',
            ],
            [
                'username' => 'petugas',
                'password' => Hash::make('petugas123'),
                'nama'     => 'Petugas Pembiayaan',
                'peran'    => 'petugas',
            ],
        ];

        foreach ($pengguna as $data) {
            Pengguna::updateOrCreate(['username' => $data['username']], $data);
        }
    }
}
