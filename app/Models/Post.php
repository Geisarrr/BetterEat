<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table      = 'posts';
    protected $primaryKey = 'post_id';
    public $timestamps    = true;
    const UPDATED_AT      = null; // ← Tambahan ini: beritahu Laravel bahwa updated_at tidak ada di DB

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'image_url',
        'is_moderated',
    ];

    protected function casts(): array
    {
        return [
            'is_moderated' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'post_id';
    }

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