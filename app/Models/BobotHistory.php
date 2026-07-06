<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BobotHistory extends Model
{
    protected $table = 'bobot_history';
    protected $primaryKey = 'id_bobot';
    public $timestamps = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'id_periode',
        'id_kriteria',
        'bobot_mentah',
        'bobot_normalisasi',
    ];

    protected function casts(): array
    {
        return [
            'bobot_mentah'      => 'integer',
            'bobot_normalisasi' => 'float',
            'created_at'        => 'datetime',
        ];
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}
