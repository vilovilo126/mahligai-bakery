<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Suasana Toko',
                'category' => 'interior',
                'description' => 'Desain interior hangat dan bersih dengan sentuhan kayu alami.',
                'image' => 'images/gallery/toko.svg',
                'sort_order' => 1,
            ],
            [
                'title' => 'Fresh Baked Donat',
                'category' => 'produk',
                'description' => 'Donat glazed segar dari oven, siap disantap.',
                'image' => 'images/gallery/fresh-donat.svg',
                'sort_order' => 2,
            ],
            [
                'title' => 'Ruang Oven',
                'category' => 'proses',
                'description' => 'Proses pemanggangan setiap hari mulai dini hari.',
                'image' => 'images/gallery/oven.svg',
                'sort_order' => 3,
            ],
            [
                'title' => 'Display Croissant',
                'category' => 'display',
                'description' => 'Jajaran croissant yang menggoda di etalase.',
                'image' => 'images/gallery/display-croissant.svg',
                'sort_order' => 4,
            ],
            [
                'title' => 'Tampilan Toko',
                'category' => 'interior',
                'description' => 'Tampilan depan Mahligai Bakery.',
                'image' => 'images/gallery/tampilan-toko.svg',
                'sort_order' => 5,
            ],
            [
                'title' => 'Display Kue',
                'category' => 'display',
                'description' => 'Berbagai pilihan cake dan pastry untuk segala momen.',
                'image' => 'images/gallery/display-kue.svg',
                'sort_order' => 6,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::updateOrCreate(
                ['title' => $gallery['title']],
                [
                    'category' => $gallery['category'],
                    'description' => $gallery['description'],
                    'image' => $gallery['image'],
                    'sort_order' => $gallery['sort_order'],
                    'is_active' => true,
                ],
            );
        }
    }
}
