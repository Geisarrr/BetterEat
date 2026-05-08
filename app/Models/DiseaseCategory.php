<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseCategory extends Model
{
    use HasFactory;

    // 1. Beri tahu Laravel nama tabel aslinya di database
    protected $table = 'disease_categories';

    // 2. Beri tahu Laravel bahwa Primary Key kustom kita bernama 'category_id'
    protected $primaryKey = 'category_id';

    // 3. Daftarkan kolom mana saja yang diizinkan untuk diisi data (sangat penting!)
    protected $fillable = [
        'name',
        'description',
    ];
}