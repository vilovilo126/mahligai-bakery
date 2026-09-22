<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_is_redirected_to_dashboard(): void
    {
        User::factory()->create([
            'username' => 'admin',
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $this->post(route('login.submit'), [
            'username' => 'admin',
            'password' => 'secret123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_customer_can_login_and_is_redirected_to_menu(): void
    {
        User::factory()->customer()->create([
            'username' => 'budi_santoso',
            'password' => 'secret123',
        ]);

        $this->post(route('login.submit'), [
            'username' => 'budi_santoso',
            'password' => 'secret123',
        ])->assertRedirect(route('menu'));

        $this->assertAuthenticated();
    }

    public function test_login_with_wrong_password_returns_validation_error(): void
    {
        User::factory()->create([
            'username' => 'admin',
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $this->post(route('login.submit'), [
            'username' => 'admin',
            'password' => 'salah',
        ])->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_login_requires_username_and_password(): void
    {
        $this->post(route('login.submit'), [
            'username' => '',
            'password' => '',
        ])->assertSessionHasErrors(['username', 'password']);

        $this->assertGuest();
    }

    public function test_guest_login_page_renders(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Mahligai Bakery')
            ->assertSee('Username')
            ->assertSee('Kata Sandi');
    }

    public function test_logged_in_admin_visiting_login_is_redirected_to_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        $this->get(route('login'))->assertRedirect(route('admin.dashboard'));
    }

    public function test_logged_in_customer_visiting_login_is_redirected_to_menu(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer);

        $this->get(route('login'))->assertRedirect(route('menu'));
    }

    public function test_logout_redirects_to_home_and_clears_session(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        $this->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_logout_requires_authentication(): void
    {
        $this->post(route('logout'))->assertRedirect(route('login'));
    }
}
