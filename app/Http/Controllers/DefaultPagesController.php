<?php

namespace App\Http\Controllers;

use App\Models\Parfum;
use Inertia\Inertia;

class DefaultPagesController extends Controller
{
    public function welcome() {
        return Inertia::render('Welcome');
    }

    public function home($sex = null)
    {
        if ($sex) {
            $parfumes = Parfum::query()
                ->when($sex, function ($query, $sex) {
                    return $query->where('sex', $sex);
                })
                ->get();
        }

        return Inertia::render('pages/Home', [
            'parfumes' => $parfumes ?? []
        ]);
    }
}
