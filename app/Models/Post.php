<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'post_id';

    // Matikan fitur updated_at karena di migration hanya ada created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'is_moderated',
    ];

    protected function casts(): array
    {
        return [
            'is_moderated' => 'boolean',
        ];
    }

    /**
     * Relasi ke tabel User (Siapa yang membuat post ini)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke tabel Disease Category (Kategori penyakit yang dibahas)
     */
    public function category()
    {
        return $this->belongsTo(DiseaseCategory::class, 'category_id', 'category_id');
    }
}