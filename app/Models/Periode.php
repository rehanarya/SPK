<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    protected $table = 'periode';
    protected $primaryKey = 'id_periode';
    public $timestamps = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'kode_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
            'created_at'      => 'datetime',
        ];
    }

    public function pengajuan(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'id_periode', 'id_periode');
    }

    public function bobotHistory(): HasMany
    {
        return $this->hasMany(BobotHistory::class, 'id_periode', 'id_periode');
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
