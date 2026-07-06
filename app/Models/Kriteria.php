<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    public $timestamps = false;

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'bobot_mentah',
        'bobot_normalisasi',
        'tipe',
        'satuan',
    ];

    protected function casts(): array
    {
        return [
            'bobot_mentah'       => 'integer',
            'bobot_normalisasi'  => 'float',
            'tipe'               => 'string',
        ];
    }

    public function bobotHistory(): HasMany
    {
        return $this->hasMany(BobotHistory::class, 'id_kriteria', 'id_kriteria');
    }

    public function isBenefit(): bool
    {
        return $this->tipe === 'benefit';
    }

    public function isCost(): bool
    {
        return $this->tipe === 'cost';
    }

    /** Tanda eksponen WP: +1 benefit, -1 cost */
    public function eksponen(): int
    {
        return $this->isBenefit() ? 1 : -1;
    }
}
