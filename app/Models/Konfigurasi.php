<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    protected $table = 'konfigurasi';
    protected $primaryKey = 'id_konfigurasi';

    protected $fillable = [
        'kunci',
        'nilai',
        'deskripsi',
    ];

    /** Ambil nilai konfigurasi by kunci, kembalikan default jika tidak ada */
    public static function ambil(string $kunci, mixed $default = null): mixed
    {
        $record = static::where('kunci', $kunci)->first();
        return $record ? $record->nilai : $default;
    }

    /** Set nilai konfigurasi by kunci */
    public static function set(string $kunci, mixed $nilai, ?string $deskripsi = null): static
    {
        return static::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => (string) $nilai, 'deskripsi' => $deskripsi]
        );
    }
}
