<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * Data testimoni berikut merupakan contoh/dummy dan mudah untuk diganti
     * dengan ulasan asli pelanggan melalui database.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Nadia Putri',
                'avatar' => 'images/avatars/avatar-1.svg',
                'rating' => 5,
                'comment' => 'Croissant-nya luar biasa! Renyah, hangat, dan menteganya terasa premium. Pasti balik lagi.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Bagas Pratama',
                'avatar' => 'images/avatars/avatar-2.svg',
                'rating' => 5,
                'comment' => 'Chocolate cake-nya jadi favorit keluarga. Bahannya terasa fresh dan tidak terlalu manis.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Sari Wulandari',
                'avatar' => 'images/avatars/avatar-3.svg',
                'rating' => 4,
                'comment' => 'Pelayanannya ramah dan toko-nya bersih. Donat glazed selalu jadi andalan pagi ini.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Dimas Aditya',
                'avatar' => 'images/avatars/avatar-4.svg',
                'rating' => 5,
                'comment' => 'Enak banget, harga masuk akal untuk kualitas segini. Sourdough-nya patut dicoba.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Rina Maharani',
                'avatar' => 'images/avatars/avatar-5.svg',
                'rating' => 5,
                'comment' => 'Suasananya nyaman, aromanya harum dari jauh. Pelayanannya juga cepat.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Fajar Nugroho',
                'avatar' => 'images/avatars/avatar-6.svg',
                'rating' => 4,
                'comment' => 'Cookies-nya crispy di luar, chewy di dalam. Rekomendasi buat penggemar cokelat.',
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                [
                    'avatar' => $testimonial['avatar'],
                    'rating' => $testimonial['rating'],
                    'comment' => $testimonial['comment'],
                    'sort_order' => $testimonial['sort_order'],
                    'is_active' => true,
                ],
            );
        }
    }
}