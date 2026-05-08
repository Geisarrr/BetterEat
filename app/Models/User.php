<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 1. Wajib tambahkan ini untuk Token API

class User extends Authenticatable
{
    // 2. Tambahkan HasApiTokens di sini
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    // 3. Matikan fitur updated_at karena di tabel users kita hanya punya created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password_hash', // 4. Ubah dari 'password' menjadi 'password_hash'
        'role',
        'profile_photo',
        'is_active',     // Tambahan sesuai tabel ERD
    ];

    protected $hidden = [
        'password_hash', // 5. Ubah dari 'password'
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // Bagian 'password' => 'hashed' dihapus karena kita melakukan Hash manual di Controller
        ];
    }

    /**
     * 6. Method Overriding untuk mengarahkan fitur Auth bawaan Laravel
     * agar membaca kolom 'password_hash' dan bukan 'password'.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}