<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun admin Mahligai Bakery.
     *
     * Kredensial diambil dari .env (ADMIN_USERNAME / ADMIN_PASSWORD)
     * dengan nilai default sesuai kebutuhan. Password selalu di-hash.
     */
    public function run(): void
    {
        $username = (string) env('ADMIN_USERNAME', 'admin');
        $password = (string) env('ADMIN_PASSWORD', 'bakery mahligai');
        $email = (string) env('ADMIN_EMAIL', 'admin@mahligai-bakery.test');

        $admin = User::query()
            ->where('username', $username)
            ->orWhere('email', $email)
            ->first();

        $attributes = [
            'username' => $username,
            'name' => env('ADMIN_NAME', 'Admin Mahligai Bakery'),
            'email' => $email,
            'password' => $password,
            'role' => 'admin',
            'whatsapp_number' => config('business.whatsapp_number'),
        ];

        if ($admin) {
            $admin->update($attributes);
        } else {
            User::create($attributes);
        }
    }
}
