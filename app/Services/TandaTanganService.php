<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

/**
 * Konversi tanda tangan digital (dataURL PNG dari komponen x-signature-pad)
 * menjadi file di storage/app/public/ttd/ — kolom database hanya menyimpan
 * path relatif, bukan base64.
 *
 * Prasyarat tampilan web: `php artisan storage:link` agar public/storage
 * menunjuk ke storage/app/public.
 */
class TandaTanganService
{
    /**
     * Simpan dataURL PNG sebagai file dan kembalikan path relatifnya.
     * Mengembalikan null bila dataURL kosong/tidak valid.
     */
    public function simpan(?string $dataUrl, string $prefix): ?string
    {
        if (! $dataUrl || ! str_starts_with($dataUrl, 'data:image/png;base64,')) {
            return null;
        }

        $binary = base64_decode(substr($dataUrl, strlen('data:image/png;base64,')), true);

        if ($binary === false || $binary === '') {
            return null;
        }

        $path = 'ttd/' . uniqid($prefix . '_', true) . '.png';
        Storage::disk('public')->put($path, $binary);

        return $path;
    }
}
