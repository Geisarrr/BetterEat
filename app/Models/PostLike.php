<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    use HasFactory;

    protected $table = 'post_likes';

    // Matikan auto-increment karena menggunakan composite key (post_id & user_id)
    public $incrementing = false;

    // Matikan timestamps karena tidak didefinisikan di migration
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    /**
     * Relasi ke tabel Post (Postingan apa yang di-like)
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    /**
     * Relasi ke tabel User (Siapa yang nge-like)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}