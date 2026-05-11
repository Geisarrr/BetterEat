<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; -> Baris ini kita hapus

class User extends Authenticatable
{
    // HasApiTokens kita hapus dari sini, sisakan HasFactory dan Notifiable
    use HasFactory, Notifiable; 

    /**
     * Mengarahkan Primary Key ke 'user_id' sesuai skema tabel users.
     */
    protected $primaryKey = 'user_id';

    /**
     * Menonaktifkan updated_at jika tabel hanya memiliki created_at.
     */
    public $timestamps = true; 
    const UPDATED_AT = null; 

    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password_hash',
        'role',
        'profile_photo',
    ];

    /**
     * Menyembunyikan password_hash demi keamanan (meskipun tidak pakai JSON lagi, ini tetap Best Practice).
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * SANGAT PENTING: Memberitahu Laravel bahwa kolom password bernama 'password_hash'.
     * Ini jantungnya sistem login (Auth::attempt) kita sekarang.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}