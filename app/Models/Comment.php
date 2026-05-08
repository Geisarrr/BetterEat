<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'comment_id';

    // Matikan fitur updated_at karena di migration hanya ada created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_comment_id',
        'content',
    ];

    /**
     * Relasi ke tabel Post (Komentar ini ada di postingan mana)
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    /**
     * Relasi ke tabel User (Siapa yang menulis komentar)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi Induk (Mencari komentar utama yang sedang dibalas)
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id', 'comment_id');
    }

    /**
     * Relasi Anak (Mengambil semua balasan untuk komentar ini)
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id', 'comment_id');
    }
}