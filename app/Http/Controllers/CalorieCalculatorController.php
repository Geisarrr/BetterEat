<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodNutritionTkpi;
use App\Models\CalorieLog;
use Illuminate\Support\Facades\Auth;

class CalorieCalculatorController extends Controller
{
    /**
     * Tampilkan halaman kalkulator gizi.
     */
    public function index()
    {
        $recentLogs = [];
        if (Auth::check()) {
            $recentLogs = CalorieLog::with('food')
                ->where('user_id', Auth::id())
                ->orderBy('logged_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('calculator', compact('recentLogs'));
    }

    /**
     * GET /kalkulator/search?q=ayam
     * Kembalikan food_id, food_name, calories_kcal (alias), protein_g, fat_g, carbs_g
     */
    public function search(Request $request)
    {
        $keyword = $request->query('q', '');

        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        // Pilih kolom yang dibutuhkan; calories_kcal di-append via model accessor
        $foods = FoodNutritionTkpi::where('food_name', 'like', "%{$keyword}%")
            ->select('food_id', 'food_name', 'calories_per_100g', 'protein_g', 'fat_g', 'carbs_g')
            ->limit(10)
            ->get();

        // Transform agar JS selalu menerima key 'calories_kcal'
        $result = $foods->map(fn($f) => [
            'food_id'      => $f->food_id,
            'food_name'    => $f->food_name,
            'calories_kcal'=> (float) $f->calories_per_100g,
            'protein_g'    => (float) $f->protein_g,
            'fat_g'        => (float) $f->fat_g,
            'carbs_g'      => (float) $f->carbs_g,
        ]);

        return response()->json($result);
    }

    /**
     * POST /kalkulator/calculate
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'items'                   => 'required|array|min:1',
            'items.*.food_id'         => 'required|exists:food_nutrition_tkpi,food_id',
            'items.*.quantity_gram'   => 'required|numeric|min:1',
        ]);

        $totals = ['calories' => 0, 'protein' => 0, 'fat' => 0, 'carbs' => 0];
        $details = [];

        foreach ($request->items as $item) {
            $food  = FoodNutritionTkpi::find($item['food_id']);
            $ratio = $item['quantity_gram'] / 100;

            // Gunakan calories_per_100g (nama kolom asli di DB)
            $cal  = round($food->calories_per_100g * $ratio, 1);
            $prot = round($food->protein_g         * $ratio, 1);
            $fat  = round($food->fat_g             * $ratio, 1);
            $carb = round($food->carbs_g           * $ratio, 1);

            $totals['calories'] += $cal;
            $totals['protein']  += $prot;
            $totals['fat']      += $fat;
            $totals['carbs']    += $carb;

            $details[] = [
                'food_id'       => $food->food_id,
                'food_name'     => $food->food_name,
                'quantity_gram' => $item['quantity_gram'],
                'calories'      => $cal,
                'protein_g'     => $prot,
                'fat_g'         => $fat,
                'carbs_g'       => $carb,
            ];
        }

        $dailyCalorieGoal = Auth::check()
            ? (Auth::user()->profile->daily_calorie_target ?? 2000)
            : 2000;

        $caloriePercentage = ($totals['calories'] / $dailyCalorieGoal) * 100;

        $status = match (true) {
            $caloriePercentage <= 30 => ['label' => 'Aman',           'color' => 'green'],
            $caloriePercentage <= 60 => ['label' => 'Cukup',          'color' => 'yellow'],
            default                  => ['label' => 'Perlu Dibatasi', 'color' => 'red'],
        };

        // Simpan ke calorie_logs jika user login
        if (Auth::check()) {
            foreach ($details as $d) {
                CalorieLog::create([
                    'user_id'       => Auth::id(),
                    'food_id'       => $d['food_id'],
                    'quantity_gram' => $d['quantity_gram'],
                    'calories'      => $d['calories'],
                    'protein_g'     => $d['protein_g'],
                    'fat_g'         => $d['fat_g'],
                    'carbs_g'       => $d['carbs_g'],
                ]);
            }
        }

        return response()->json([
            'totals'     => array_map(fn($v) => round($v, 1), $totals),
            'details'    => $details,
            'status'     => $status,
            'daily_goal' => $dailyCalorieGoal,
        ]);
    }

    /**
     * GET /kalkulator/alternatives?food_id=5
     */
    public function alternatives(Request $request)
    {
        $foodId = $request->query('food_id');
        $food   = FoodNutritionTkpi::find($foodId);

        if (!$food) {
            return response()->json([]);
        }

        $alternatives = FoodNutritionTkpi::where('food_id', '!=', $foodId)
            ->where('calories_per_100g', '<', $food->calories_per_100g)
            ->where('protein_g', '>=', $food->protein_g * 0.5)
            ->select('food_id', 'food_name', 'calories_per_100g', 'protein_g', 'fat_g', 'carbs_g')
            ->orderBy('calories_per_100g', 'asc')
            ->limit(4)
            ->get();

        // Transform ke format yang sama dengan search (key calories_kcal)
        $result = $alternatives->map(fn($f) => [
            'food_id'       => $f->food_id,
            'food_name'     => $f->food_name,
            'calories_kcal' => (float) $f->calories_per_100g,
            'protein_g'     => (float) $f->protein_g,
            'fat_g'         => (float) $f->fat_g,
            'carbs_g'       => (float) $f->carbs_g,
        ]);

        return response()->json($result);
    }
}