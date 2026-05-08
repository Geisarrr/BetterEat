<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Beritahu Laravel nama Primary Key kustom dari ERD-mu
    protected $primaryKey = 'user_id';

    // 2. Daftarkan kolom yang diizinkan untuk diisi data (Mass Assignment)
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password',
        'role',
        'profile_photo',
    ];

    // 3. Sembunyikan kolom sensitif saat data user dipanggil (misal lewat API)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 4. Casting tipe data bawaan Laravel
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Laravel otomatis mengelola hash password di sini juga
        ];
    }
}