<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi mass assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'active',     // penting untuk owner/kasir
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Helper untuk ngecek role
     * Biar gampang: auth()->user()->isOwner()
     */
    public function isOwner()
    {
        return $this->role === 'owner';
    }

    public function isKasir()
    {
        return $this->role === 'kasir';
    }
}
