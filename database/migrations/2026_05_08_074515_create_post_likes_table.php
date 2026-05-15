<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table    = 'posts';
    protected $primaryKey = 'post_id';

    // Migration create_posts_table.php menggunakan $table->timestamps()
    // artinya updated_at ADA — hapus baris const UPDATED_AT = null dari versi lama
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'image_url',       // ← Ini yang menyebabkan error sebelumnya — belum ada di fillable
        'is_moderated',
    ];

    protected function casts(): array
    {
        return [
            'is_moderated' => 'boolean',
        ];
    }

    // ── Relasi ──────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(DiseaseCategory::class, 'category_id', 'category_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id', 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }
}