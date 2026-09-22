<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomersToUsersMigrationTest extends TestCase
{
    use RefreshDatabase;

    private function migration(): Migration
    {
        $migration = include database_path('migrations/2026_09_21_024927_add_customer_accounts_to_users_table.php');

        return $migration;
    }

    private function createLegacyCustomer(): int
    {
        return DB::table('customers')->insertGetId([
            'name' => 'Ayu Lestari',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createLegacyOrder(int $customerId): int
    {
        return DB::table('orders')->insertGetId([
            'customer_id' => $customerId,
            'queue_number' => 1,
            'customer_name' => 'Ayu Lestari',
            'customer_phone' => '081111111111',
            'payment_method' => 'wa',
            'order_status' => 'pesanan_dibuat',
            'payment_status' => 'belum_bayar',
            'pickup_date' => now()->addDay(),
            'pickup_time' => '11:00',
            'subtotal' => 10000,
            'add_ons_total' => 0,
            'qris_fee' => 0,
            'total' => 10000,
            'order_data' => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createLegacyNotification(int $customerId): string
    {
        $id = (string) Str::uuid();

        DB::table('notifications')->insert([
            'id' => $id,
            'type' => AppNotification::class,
            'notifiable_type' => 'App\\Models\\Customer',
            'notifiable_id' => $customerId,
            'data' => json_encode(['title' => 'Selamat Datang', 'body' => 'Halo']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $id;
    }

    private function foreignKeyNames(string $table, string $column): array
    {
        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', config('database.connections.mysql.database'))
            ->where('TABLE_NAME', $table)
            ->where('COLUMN_NAME', $column)
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->pluck('CONSTRAINT_NAME')
            ->all();
    }

    public function test_up_converts_customer_into_user_and_repoints_relations(): void
    {
        $this->migration()->down();

        $customerId = $this->createLegacyCustomer();
        $orderId = $this->createLegacyOrder($customerId);
        $chatId = DB::table('chats')->insertGetId([
            'customer_id' => $customerId,
            'last_message_at' => now(),
        ]);
        $notificationId = $this->createLegacyNotification($customerId);

        $this->migration()->up();

        $user = User::query()->where('name', 'Ayu Lestari')->where('role', 'customer')->firstOrFail();

        $this->assertSame($user->id, DB::table('customers')->where('id', $customerId)->value('account_user_id'));
        $this->assertSame($user->id, DB::table('orders')->where('id', $orderId)->value('customer_id'));
        $this->assertSame($user->id, DB::table('chats')->where('id', $chatId)->value('customer_id'));

        $this->assertSame('pelanggan-'.$customerId.'@mahligai-bakery.test', $user->email);
        $this->assertNotEmpty($user->password);
        $this->assertNotSame('pelanggan', $user->password);
        $this->assertTrue(Hash::isHashed($user->password));
        $this->assertFalse(Hash::check('pelanggan', $user->password));

        $notification = DB::table('notifications')->where('id', $notificationId)->first();
        $this->assertSame('App\\Models\\User', $notification->notifiable_type);
        $this->assertSame($user->id, (int) $notification->notifiable_id);

        if (DB::connection()->getDriverName() === 'mysql') {
            $this->assertSame([], $this->foreignKeyNames('orders', 'customer_id'));
            $this->assertSame([], $this->foreignKeyNames('chats', 'customer_id'));
        }
    }

    public function test_down_restores_customer_relations_and_drops_user_accounts(): void
    {
        $this->migration()->down();

        $customerId = $this->createLegacyCustomer();
        $orderId = $this->createLegacyOrder($customerId);
        $chatId = DB::table('chats')->insertGetId([
            'customer_id' => $customerId,
            'last_message_at' => now(),
        ]);
        $notificationId = $this->createLegacyNotification($customerId);

        $this->migration()->up();

        $accountUserId = DB::table('customers')->where('id', $customerId)->value('account_user_id');

        $this->migration()->down();

        $this->assertSame($customerId, DB::table('orders')->where('id', $orderId)->value('customer_id'));
        $this->assertSame($customerId, DB::table('chats')->where('id', $chatId)->value('customer_id'));

        $notification = DB::table('notifications')->where('id', $notificationId)->first();
        $this->assertSame('App\\Models\\Customer', $notification->notifiable_type);
        $this->assertSame($customerId, (int) $notification->notifiable_id);

        $this->assertSame(0, User::query()->where('id', $accountUserId)->where('role', 'customer')->count());
        $this->assertFalse(Schema::hasColumn('customers', 'account_user_id'));

        if (DB::connection()->getDriverName() === 'mysql') {
            $this->assertSame(['orders_customer_id_foreign'], $this->foreignKeyNames('orders', 'customer_id'));
            $this->assertSame(['chats_customer_id_foreign'], $this->foreignKeyNames('chats', 'customer_id'));
        }
    }
}
