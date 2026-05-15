<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; 

    protected $primaryKey = 'user_id';

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
     * RELASI KE PROFILE (user_profiles)
     * Ini supaya kita bisa panggil: Auth::user()->profile->daily_calorie_target
     */
    public function profile()
    {
        // 'user_id' di sini adalah foreign key di tabel user_profiles
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    /**
     * RELASI KE JURNAL KALORI (calorie_logs)
     * Ini supaya kita bisa hitung total kalori yang sudah dimakan hari ini
     */
    public function calorieLogs()
    {
        return $this->hasMany(CalorieLog::class, 'user_id');
    }

    // --- FUNGSI LOGIN ---

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }
}