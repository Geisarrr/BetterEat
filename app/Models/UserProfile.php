<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';
    protected $primaryKey = 'profile_id';

    protected $fillable = [
        'user_id',
        'health_condition',
        'daily_calorie_target',
        'age',
        'weight_kg',
    ];

    /**
     * Relasi ke tabel User (Setiap 1 profil dimiliki oleh 1 user)
     */
    public function user()
    {
        // belongsTo(NamaModel::class, 'foreign_key_di_sini', 'primary_key_di_target')
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}