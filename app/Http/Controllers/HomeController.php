<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class HomeController extends Controller
{
    /**
     * Display the BetterEat homepage.
     */
    public function index()
    {
        // Ambil data resep dari database
        $recipes = Recipe::all();

        $articles = [
             [
                'title' => 'Pentingnya Minum Air Putih Setiap Hari',
                'preview' => 'Air putih membantu menjaga metabolisme tubuh dan mencegah dehidrasi.',
                'image' => 'https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=800&q=80',
                'category' => 'Kesehatan',
                'slug' => 'manfaat-air-putih',
                'date' => '18 Mei 2025',
            ],

            [
                'title' => 'Manfaat Sayuran Hijau untuk Memenuhi Nutrisi Harian Tubuh',
                'preview' => 'Bayam, brokoli, dan kangkung kaya vitamin yang baik untuk tubuh.',
                'image' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=800&q=80',
                'category' => 'Nutrisi',
                'slug' => 'sayuran-hijau',
                'date' => '20 Mei 2025',
            ],
            [
                'title' => 'Tips Mengatur Pola Makan Bergizi agar Tubuh Tetap Fit dan Sehat',
                'preview' => 'Mulailah hidup sehat dengan pola makan bergizi seimbang.',
                'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&q=75',
                'category' => 'Lifestyle',
                'slug' => 'tips-makan-sehat',
                'date' => '10 Mei 2025',
            ],
            [
                'title' => 'Rahasia Sarapan Bergizi untuk Aktivitas Padat',
                'preview' => 'Sarapan sehat membantu meningkatkan fokus dan energi sepanjang hari.',
                'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=400&q=75',
                'category' => 'Healthy Food',
                'slug' => 'sarapan-bergizi',
                'date' => '15 Mei 2025',
            ],
        ];

        // Data dummy testimonial
        $testimonials = [
            [
                'name' => 'Rina Sari',
                'role' => 'Mahasiswa',
                'text' => 'BetterEat membantu saya menjaga pola makan sehat setiap hari.',
                'rating' => 5,
            ],
            [
                'name' => 'Dimas',
                'role' => 'Karyawan',
                'text' => 'UI nya bagus dan resepnya mudah diikuti.',
                'rating' => 5,
            ],
            [
                'name' => 'Nabila Putri',
                'role' => 'Ibu Rumah Tangga',
                'text' => 'Sekarang saya jadi lebih mudah memilih menu sehat untuk keluarga.',
                'rating' => 5,
            ],
        ];

        // Kirim data ke view
        return view('home', compact(
            'recipes',
            'articles',
            'testimonials'
        ));
    }
}