<?php

namespace Database\Seeders;

use App\Enums\ProductBadge;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug');

        $products = [
            [
                'name' => 'Roti Sourdough',
                'slug' => 'roti-sourdough',
                'category' => 'roti',
                'description' => 'Roti sourdough artisan dengan tekstur kenyal, kulit renyah, dan rasa asam ringan dari fermentasi alami.',
                'price' => 65_000,
                'image' => 'images/products/roti-sourdough.svg',
                'badge' => ProductBadge::Recommended,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Croissant Mentega',
                'slug' => 'croissant-mentega',
                'category' => 'pastry',
                'description' => 'Croissant berlapis dengan mentega premium, renyah di luar dan lembut berongga di dalam.',
                'price' => 28_000,
                'image' => 'images/products/croissant-mentega.svg',
                'badge' => ProductBadge::BestSeller,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Chocolate Cake',
                'slug' => 'chocolate-cake',
                'category' => 'kue',
                'description' => 'Kue cokelat pekat berlapis ganache yang lumer di mulut, cocok untuk momen istimewa.',
                'price' => 185_000,
                'image' => 'images/products/chocolate-cake.svg',
                'badge' => ProductBadge::Favorite,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Fudgy Brownies',
                'slug' => 'fudgy-brownies',
                'category' => 'kue',
                'description' => 'Brownies fudgy tebal dengan cokelat pekat dan tekstur lembut yang memanjakan lidah.',
                'price' => 45_000,
                'image' => 'images/products/fudgy-brownies.svg',
                'badge' => null,
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Donat Glazed',
                'slug' => 'donat-glazed',
                'category' => 'donat',
                'description' => 'Donat empuk berbalut glaze gula manis yang dibuat segar setiap pagi.',
                'price' => 18_000,
                'image' => 'images/products/donat-glazed.svg',
                'badge' => ProductBadge::BestSeller,
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Chocolate Chip Cookies',
                'slug' => 'chocolate-chip-cookies',
                'category' => 'cookies',
                'description' => 'Cookies kenyal dengan potongan cokelat, renyah di tepian dan lumer di tengah.',
                'price' => 39_000,
                'image' => 'images/products/chocolate-cookies.svg',
                'badge' => null,
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Cinnamon Roll',
                'slug' => 'cinnamon-roll',
                'category' => 'pastry',
                'description' => 'Gulungan lembut dengan isian kayu manis dan gula brown sugar, diberi taburan glazing.',
                'price' => 32_000,
                'image' => 'images/products/cinnamon-roll.svg',
                'badge' => null,
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'Pain au Chocolat',
                'slug' => 'pain-au-chocolat',
                'category' => 'pastry',
                'description' => 'Pastry renyah berlapis dengan isian dua batang cokelat berkualitas di tengahnya.',
                'price' => 35_000,
                'image' => 'images/products/pain-chocolat.svg',
                'badge' => null,
                'is_featured' => false,
                'sort_order' => 8,
            ],
            [
                'name' => 'Bagel',
                'slug' => 'bagel',
                'category' => 'roti',
                'description' => 'Bagel kenyal dengan permukaan mengkilap, tersedia varian original dan biji wijen.',
                'price' => 25_000,
                'image' => 'images/products/bagel.svg',
                'badge' => null,
                'is_featured' => false,
                'sort_order' => 9,
            ],
            [
                'name' => 'Cheesecake Beri',
                'slug' => 'cheesecake-beri',
                'category' => 'kue',
                'description' => 'Creamy cheesecake di atas biskuit renyah dengan topping buah beri segar.',
                'price' => 165_000,
                'image' => 'images/products/cheesecake-beri.svg',
                'badge' => null,
                'is_featured' => false,
                'sort_order' => 10,
            ],
            [
                'name' => 'Croissant Almond',
                'slug' => 'croissant-almond',
                'category' => 'pastry',
                'description' => 'Croissant isi krim almond dengan taburan almond panggang yang harum dan gurih.',
                'price' => 38_000,
                'image' => 'images/products/croissant-almond.svg',
                'badge' => ProductBadge::Recommended,
                'is_featured' => false,
                'sort_order' => 11,
            ],
            [
                'name' => 'Baguette Segar',
                'slug' => 'baguette-segar',
                'category' => 'roti',
                'description' => 'Baguette klasik Prancis yang renyah di luar dan lembut di dalam, dipanggang dua kali sehari.',
                'price' => 42_000,
                'image' => 'images/products/baguette.svg',
                'badge' => null,
                'is_featured' => false,
                'sort_order' => 12,
            ],
        ];

        foreach ($products as $index => $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'category_id' => $categories[$product['category']],
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'badge' => $product['badge'],
                    'is_featured' => $product['is_featured'],
                    'is_active' => true,
                    'sort_order' => $product['sort_order'] ?? $index,
                ],
            );
        }
    }
}