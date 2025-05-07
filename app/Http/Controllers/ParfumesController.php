<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Parfum;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParfumesController extends Controller
{
    public function index(Request $request)
    {
        // Get filters from request
        $sex = $request->get('sex');
        $brand = $request->get('brand');
        $sort = $request->get('sort');
        $search = $request->get('search');
        $category = $request->get('category');

        $parfumes = Parfum::with(['brand', 'category']); // Add this line

        // Apply search filter if provided
        if ($search) {
            $parfumes->where('name', 'like', '%' . $search . '%');
        }

        if ($sex) {
            $parfumes->where('sex', $sex);
        }

        if ($brand) {
            $parfumes->where('brand_id', $brand);
        }

        if ($category) {
            $parfumes->where('category_id', $category);
        }

        if ($sort) {
            if ($sort === 'price_asc') {
                $parfumes->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $parfumes->orderBy('price', 'desc');
            } elseif ($sort === 'new_arrival') {
                $parfumes->where('created_at', '>=', now()->subDays(30));
            }
        }

        $parfumes = $parfumes->get();

        $brands = Brand::where('active', 1)->get();
        $categories = Category::where('active', 1)->get();

        return Inertia::render('pages/Parfumes', [
            'parfumes' => $parfumes ?? [],
            'brands' => $brands ?? [],
            'categories' => $categories ?? [],
            'sex' => $sex,
            'brand' => $brand,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show($slug)
    {
        $parfum = Parfum::with(['brand', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedParfumes = Parfum::with(['brand', 'category'])
            ->where('category_id', $parfum->category->id)
            ->where('id', '!=', $parfum->id) // Exclude current parfume
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return Inertia::render('pages/Parfume', [
            'parfum' => $parfum,
            'relatedParfumes' => $relatedParfumes,
        ]);
    }
}
