<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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
        $sort = $request->get('sort');    // price_asc / price_desc
        $search = $request->get('search'); // new: search keyword

        $parfumes = Parfum::query();

        // Apply search filter if provided
        if ($search) {
            $parfumes->where('name', 'like', '%' . $search . '%');
        }

        // Apply sex filter if provided
        if ($sex) {
            $parfumes->where('sex', $sex);
        }

        // Apply brand filter if provided
        if ($brand) {
            $parfumes->where('brand_id', $brand);
        }

        // Apply sorting by price if sort value is provided
        if ($sort) {
            if ($sort === 'price_asc') {
                $parfumes->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $parfumes->orderBy('price', 'desc');
            } elseif ($sort === 'new_arrival') {
                $parfumes->where('created_at', '>=', now()->subDays(30));
            }
        }

        // Get filtered parfumes
        $parfumes = $parfumes->get();

        // Get available brands
        $brands = Brand::where('active', 1)->get();

        // Return data to the view
        return Inertia::render('pages/Parfumes', [
            'parfumes' => $parfumes ?? [],
            'brands' => $brands ?? [],
            'sex' => $sex,
            'brand' => $brand,
            'search' => $search,
            'sort' => $sort,
        ]);
    }
}
