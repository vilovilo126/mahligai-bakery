<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(string $password = 'secret123'): User
    {
        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => $password,
            'role' => 'admin',
            'whatsapp_number' => '628113996988',
        ]);

        $this->actingAs($admin);

        return $admin;
    }

    public function test_admin_can_view_profile_page(): void
    {
        $admin = $this->actingAsAdmin();

        $this->get(route('admin.profile'))
            ->assertOk()
            ->assertSee($admin->name)
            ->assertSee('Ubah Kata Sandi');
    }

    public function test_admin_can_update_profile(): void
    {
        $this->actingAsAdmin();

        $this->put(route('admin.profile.update'), [
            'name' => 'Nana Bakery',
            'whatsapp_number' => '6281298765432',
        ]);

        $admin = User::where('username', 'admin')->firstOrFail();

        $this->assertSame('Nana Bakery', $admin->name);
        $this->assertSame('6281298765432', $admin->whatsapp_number);
    }

    public function test_admin_can_upload_avatar(): void
    {
        Storage::fake('public');
        $this->actingAsAdmin();

        $this->put(route('admin.profile.update'), [
            'name' => 'Nana Bakery',
            'avatar' => UploadedFile::fake()->image('avatar.png', 100, 100),
        ]);

        $admin = User::where('username', 'admin')->firstOrFail();

        $this->assertNotNull($admin->avatar_path);
        Storage::disk('public')->assertExists($admin->avatar_path);
    }

    public function test_update_requires_name(): void
    {
        $this->actingAsAdmin();

        $this->put(route('admin.profile.update'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_password_change_fails_with_wrong_current_password(): void
    {
        $this->actingAsAdmin();

        $this->put(route('admin.profile.password'), [
            'current_password' => 'salah',
            'new_password' => 'passwordbaru123',
            'new_password_confirmation' => 'passwordbaru123',
        ])->assertSessionHasErrors('current_password');

        $admin = User::where('username', 'admin')->firstOrFail();
        $this->assertTrue(password_verify('secret123', $admin->password));
    }

    public function test_password_change_succeeds_with_correct_current_password(): void
    {
        $this->actingAsAdmin();

        $this->put(route('admin.profile.password'), [
            'current_password' => 'secret123',
            'new_password' => 'passwordbaru123',
            'new_password_confirmation' => 'passwordbaru123',
        ])->assertRedirect();

        $admin = User::where('username', 'admin')->firstOrFail();
        $this->assertTrue(password_verify('passwordbaru123', $admin->password));
    }
}
