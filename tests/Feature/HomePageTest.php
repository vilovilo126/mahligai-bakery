<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_all_sections(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Rasa Hangat')
            ->assertSee('Katalog Menu Mahligai Bakery')
            ->assertSee('ROTI UNYIL ANEKA RASA')
            ->assertSee('ROTI SISIR')
            ->assertSee('ANEKA ROTI (REGULAR BREAD)')
            ->assertSee('Temukan Kami di Denpasar')
            ->assertSee('Apa Kata Pelanggan Kami');
    }

    public function test_menu_catalog_renders_driven_data(): void
    {
        $menuGroups = config('menu.groups', []);

        $this->assertNotEmpty($menuGroups);

        $this->get('/')
            ->assertOk()
            ->assertSee('Smoked Beef Cheese')
            ->assertSee('Selai Nanas')
            ->assertSee("MAHLIGAI'S BEST SELLER")
            ->assertSee('VARIAN KLASIK')
            ->assertSee('ROTI TAWAR')
            ->assertSee('ROTI SOBEK PANDAN');
    }

    public function test_home_page_renders_gallery_and_testimonials(): void
    {
        Gallery::factory()->create([
            'title' => 'Sudut Toko Kami',
            'is_active' => true,
        ]);

        Testimonial::factory()->create([
            'name' => 'Made Wijaya',
            'rating' => 5,
            'is_active' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Sudut Toko Kami')
            ->assertSee('Made Wijaya');
    }
}
