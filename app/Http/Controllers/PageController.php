<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Testimonial;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $menuGroups = config('menu.groups', []);

        $menuVariantCount = collect($menuGroups)->sum(function (array $group): int {
            if (isset($group['variant_groups'])) {
                return collect($group['variant_groups'])->sum(fn (array $vg) => count($vg['items']));
            }

            return count($group['variants'] ?? []);
        });

        $galleries = Gallery::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('home.index', compact('menuGroups', 'menuVariantCount', 'galleries', 'testimonials'));
    }
}
