<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audit_log';
    protected $primaryKey = 'id_audit';
    public $timestamps = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'id_pengguna',
        'aksi',
        'modul',
        'detail',
        'ip_address',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'detail'     => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
