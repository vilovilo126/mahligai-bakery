<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Halaman pertama: landing page / company profile Mahligai Bakery.
     * Tidak menampilkan katalog menu/pemesanan sama sekali.
     */
    public function landing(): View
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

        return view('home.landing', compact('menuVariantCount', 'galleries', 'testimonials'));
    }

    /**
     * Halaman pelanggan: /menu adalah Customer Shopping Page.
     * Pengunjung yang belum login diarahkan ke landing page.
     */
    public function index(): View|RedirectResponse
    {
        if (auth()->guest()) {
            return redirect()->route('home');
        }

        $menuGroups = config('menu.groups', []);

        return view('home.index', compact('menuGroups'));
    }
}
