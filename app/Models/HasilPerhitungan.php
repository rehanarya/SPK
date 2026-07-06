<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasilPerhitungan extends Model
{
    protected $table = 'hasil_perhitungan';
    protected $primaryKey = 'id_hasil';
    public $timestamps = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'id_pengajuan',
        'vektor_S',
        'vektor_V',
        'ranking',
        'status',
        'ttd_manager',
        'nama_manager',
    ];

    protected function casts(): array
    {
        return [
            'vektor_S'   => 'float',
            'vektor_V'   => 'float',
            'ranking'    => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function logKeputusan(): HasMany
    {
        return $this->hasMany(LogKeputusan::class, 'id_hasil_perhitungan', 'id_hasil');
    }

    public function isDiterima(): bool
    {
        return $this->status === 'diterima';
    }
}
