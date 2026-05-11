<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Article;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        
        $recipes = Recipe::all();
        $articles = Article::published()->get();
        $testimonials = Testimonial::visible()->get();

        return view('pages.home', compact('recipes', 'articles', 'testimonials'));
    }
}