<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk')
            ->assertSee(route('register'));
    }

    public function test_register_page_is_accessible(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Buat Akun Pelanggan')
            ->assertSee('Daftar');
    }

    public function test_register_creates_customer_and_logs_in(): void
    {
        $this->post(route('register.submit'), [
            'name' => 'Dewi Lestari',
            'username' => 'dewi_lestari',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect(route('menu'));

        $user = User::query()->where('username', 'dewi_lestari')->firstOrFail();

        $this->assertSame('customer', $user->role);
        $this->assertSame('Dewi Lestari', $user->name);
        $this->assertAuthenticatedAs($user);
    }

    public function test_register_rejects_duplicate_username(): void
    {
        User::factory()->customer()->create(['username' => 'dewi_lestari']);

        $this->post(route('register.submit'), [
            'name' => 'Dewi Lain',
            'username' => 'dewi_lestari',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_register_validates_password_confirmation(): void
    {
        $this->post(route('register.submit'), [
            'name' => 'Dewi Lestari',
            'username' => 'dewi_lestari',
            'password' => 'rahasia123',
            'password_confirmation' => 'berbeda123',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_register_rejects_short_password(): void
    {
        $this->post(route('register.submit'), [
            'name' => 'Dewi Lestari',
            'username' => 'dewi_lestari',
            'password' => 'rahasia',
            'password_confirmation' => 'rahasia',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }
}
