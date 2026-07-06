<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'username',
        'password',
        'nama',
        'peran',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'peran'    => 'string',
        ];
    }

    public function logKeputusan(): HasMany
    {
        return $this->hasMany(LogKeputusan::class, 'id_pengguna', 'id_pengguna');
    }

    public function auditLog(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'id_pengguna', 'id_pengguna');
    }

    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->peran === 'petugas';
    }
}
