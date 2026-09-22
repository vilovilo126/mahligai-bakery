<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $customer = User::factory()->customer()->create();
        $this->actingAs($customer);
    }

    public function test_menu_page_renders_all_sections(): void
    {
        $this->get('/menu')
            ->assertOk()
            ->assertSee('Rasa Hangat')
            ->assertSee('Katalog Menu Mahligai Bakery')
            ->assertSee('ROTI UNYIL ANEKA RASA')
            ->assertSee('ROTI SISIR')
            ->assertSee('ANEKA ROTI (REGULAR BREAD)')
            ->assertSee('Temukan Kami di Denpasar')
            ->assertDontSee('Apa Kata Pelanggan Kami');
    }

    public function test_menu_catalog_renders_driven_data(): void
    {
        $menuGroups = config('menu.groups', []);

        $this->assertNotEmpty($menuGroups);

        $this->get('/menu')
            ->assertOk()
            ->assertSee('Smoked Beef Cheese')
            ->assertSee('Selai Nanas')
            ->assertSee("MAHLIGAI'S BEST SELLER")
            ->assertSee('VARIAN KLASIK')
            ->assertSee('ROTI TAWAR')
            ->assertSee('ROTI SOBEK PANDAN');
    }
}
