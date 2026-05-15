<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\DiseaseCategory;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Menampilkan halaman Community Hub
     */
    public function index()
    {
        // Semua post dengan relasi eager loading (like juga dimuat)
        $posts = Post::with(['user', 'category', 'comments.user', 'comments.replies.user', 'likes'])
                     ->latest()
                     ->get();

        // Semua kategori penyakit untuk filter tab & form modal
        $categories = DiseaseCategory::all();

        // Trending Tags: hitung berapa post per kategori
        $trendingTags = DiseaseCategory::withCount('posts')
                            ->orderByDesc('posts_count')
                            ->take(5)
                            ->get()
                            ->map(fn($cat) => [
                                'name'  => '#' . str_replace(' ', '', $cat->name),
                                'count' => $cat->posts_count,
                            ]);

        // Top Contributors: user dengan post terbanyak
        $topContributors = User::withCount('posts')
                               ->having('posts_count', '>', 0)
                               ->orderByDesc('posts_count')
                               ->take(5)
                               ->get();

        // Sidebar Recipes: ambil 3 resep terbaru
        $sidebarRecipes = \App\Models\Recipe::with('category')
                            ->latest()
                            ->take(3)
                            ->get();

        return view('community', compact(
            'posts',
            'categories',
            'trendingTags',
            'topContributors',
            'sidebarRecipes'
        ));
    }
}