<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_bakery_content(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Rasa Hangat')
            ->assertSee('Mahligai Bakery')
            ->assertSee('Cerita Kami')
            ->assertSee('Keunggulan')
            ->assertSee('Masuk sebagai Pelanggan')
            ->assertSee(route('login'))
            ->assertDontSee('Katalog Menu Mahligai Bakery');
    }

    public function test_landing_page_links_to_whatsapp_contact(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('https://wa.me/'.config('business.whatsapp_number'))
            ->assertSee('Hubungi Kami');
    }

    public function test_guest_visiting_menu_is_redirected_to_landing(): void
    {
        $this->get('/menu')->assertRedirect('/');
    }

    public function test_landing_page_renders_gallery_and_testimonials(): void
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

    public function test_landing_page_is_accessible_for_logged_in_customer(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer);

        $this->get('/')
            ->assertOk()
            ->assertSee('Keluar')
            ->assertSee('Pesanan Saya');
    }

    public function test_landing_page_is_accessible_for_logged_in_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        $this->get('/')
            ->assertOk()
            ->assertSee('Dasbor');
    }
}
