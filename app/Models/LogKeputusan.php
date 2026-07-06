<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogKeputusan extends Model
{
    protected $table = 'log_keputusan';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'id_hasil_perhitungan',
        'keputusan_akhir',
        'catatan',
        'timestamp',
    ];

    protected function casts(): array
    {
        return [
            'timestamp'       => 'datetime',
            'keputusan_akhir' => 'string',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function hasilPerhitungan(): BelongsTo
    {
        return $this->belongsTo(HasilPerhitungan::class, 'id_hasil_perhitungan', 'id_hasil');
    }
}
