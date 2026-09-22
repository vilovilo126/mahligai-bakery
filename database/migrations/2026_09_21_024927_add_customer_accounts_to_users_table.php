<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Migrasikan pelanggan dari tabel customers ke tabel users (role 'customer').
     *
     * Setiap baris customers menjadi akun users dengan kata sandi acak yang di-hash
     * (aman, bukan plaintext). Relasi orders, chat, dan notification dialihkan ke
     * akun users yang baru. Tabel customers TIDAK dihapus agar bisa di-rollback.
     */
    public function up(): void
    {
        if (! Schema::hasTable('customers') || ! Schema::hasTable('users')) {
            return;
        }

        // Lepaskan FK orders/chats -> customers TERLEBIH DAHULU. Pada SQLite,
        // rebuild tabel customers (penambahan kolom account_user_id) memicu
        // ON DELETE SET NULL terhadap orders/chats sehingga relasi bisa hilang.
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('account_user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });

        $accountUserIds = [];

        foreach (DB::table('customers')->orderBy('id')->get() as $customer) {
            $username = $this->uniqueUsername((string) $customer->name, (int) $customer->id);

            $latestPhone = DB::table('orders')
                ->where('customer_id', $customer->id)
                ->whereNotNull('customer_phone')
                ->orderByDesc('id')
                ->value('customer_phone');

            $userId = DB::table('users')->insertGetId([
                'name' => $customer->name,
                'username' => $username,
                'role' => 'customer',
                'whatsapp_number' => $latestPhone,
                'email' => 'pelanggan-'.$customer->id.'@mahligai-bakery.test',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(32)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('customers')->where('id', $customer->id)->update(['account_user_id' => $userId]);

            $accountUserIds[(int) $customer->id] = $userId;
        }

        if ($accountUserIds !== []) {
            foreach ($accountUserIds as $customerId => $userId) {
                DB::table('orders')->where('customer_id', $customerId)->update(['customer_id' => $userId]);
                DB::table('chats')->where('customer_id', $customerId)->update(['customer_id' => $userId]);
            }

            foreach (DB::table('notifications')->where('notifiable_type', 'App\\Models\\Customer')->get() as $notification) {
                $userId = $accountUserIds[(int) $notification->notifiable_id] ?? null;

                if ($userId !== null) {
                    DB::table('notifications')->where('id', $notification->id)->update([
                        'notifiable_type' => 'App\\Models\\User',
                        'notifiable_id' => $userId,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('customers') || ! Schema::hasTable('users')) {
            return;
        }

        $customerRows = DB::table('customers')->whereNotNull('account_user_id')->get();
        $mappedUserIds = $customerRows->pluck('account_user_id', 'id');

        // Baris yang mengarah ke akun users di luar pemetaan (mis. dibuat setelah
        // migrasi) dikembalikan ke null agar referensi tetap konsisten.
        DB::table('orders')
            ->whereNotNull('customer_id')
            ->whereNotIn('customer_id', $mappedUserIds->values())
            ->update(['customer_id' => null]);

        foreach ($customerRows as $customer) {
            DB::table('orders')
                ->where('customer_id', $customer->account_user_id)
                ->update(['customer_id' => $customer->id]);
            DB::table('chats')
                ->where('customer_id', $customer->account_user_id)
                ->update(['customer_id' => $customer->id]);
            DB::table('notifications')
                ->where('notifiable_type', 'App\\Models\\User')
                ->where('notifiable_id', $customer->account_user_id)
                ->update([
                    'notifiable_type' => 'App\\Models\\Customer',
                    'notifiable_id' => $customer->id,
                ]);
        }

        if ($mappedUserIds->isNotEmpty()) {
            DB::table('users')->whereIn('id', $mappedUserIds->values())->where('role', 'customer')->delete();
        }

        // Turunkan kolom account_user_id SELAGI tidak ada tabel yang mereferensikan
        // customers. Pada SQLite rebuild customers dengan FK aktif akan memicu
        // ON DELETE SET NULL ke tabel yang mereferensikannya.
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['account_user_id']);
            $table->dropColumn('account_user_id');
        });

        // Pulihkan FK lintas engine (MySQL & SQLite) memakai Schema builder.
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
        });
    }

    private function uniqueUsername(string $name, int $id): string
    {
        $base = Str::of($name)->slug('_')->toString();

        if ($base === '' || $base === 'pelanggan') {
            $base = 'pelanggan_'.$id;
        } elseif ($base === 'admin') {
            $base = 'pelanggan_admin';
        }

        $username = $base;
        $counter = 1;

        while (DB::table('users')->where('username', $username)->exists()) {
            $username = $base.'_'.$counter++;
        }

        return $username;
    }
};
