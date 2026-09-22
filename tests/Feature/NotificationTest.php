<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private function notifiableCustomerWithNotification(): User
    {
        $customer = User::factory()->customer()->create();
        $customer->notify(new AppNotification('Pesanan Dibuat', 'Pesanan MB-0001 telah dibuat.', route('customer.orders')));

        return $customer;
    }

    public function test_customer_can_see_notifications_page(): void
    {
        $customer = $this->notifiableCustomerWithNotification();

        $this->actingAs($customer);

        $this->get('/customer/notifications')
            ->assertOk()
            ->assertSee('Pesanan Dibuat');
    }

    public function test_customer_list_returns_unread_count_and_items(): void
    {
        $customer = $this->notifiableCustomerWithNotification();

        $this->actingAs($customer);

        $this->getJson('/customer/notifications/list')
            ->assertOk()
            ->assertJsonPath('unread_count', 1)
            ->assertJsonCount(1, 'notifications')
            ->assertJsonPath('notifications.0.title', 'Pesanan Dibuat');
    }

    public function test_customer_can_mark_all_as_read(): void
    {
        $customer = $this->notifiableCustomerWithNotification();

        $this->actingAs($customer);

        $this->postJson('/customer/notifications/read')
            ->assertOk()
            ->assertJsonPath('unread_count', 0);

        $this->assertSame(0, $customer->unreadNotifications()->count());
    }

    public function test_customer_can_mark_one_as_read(): void
    {
        $customer = $this->notifiableCustomerWithNotification();
        $notificationId = $customer->notifications()->firstOrFail()->id;

        $this->actingAs($customer);

        $this->postJson("/customer/notifications/read/{$notificationId}")
            ->assertOk()
            ->assertJsonPath('unread_count', 0);
    }

    public function test_admin_can_see_and_mark_notifications(): void
    {
        $admin = User::factory()->create(['username' => 'admin', 'role' => 'admin']);
        $admin->notify(new AppNotification('Pesanan Baru', 'Ada pesanan baru masuk.', route('admin.orders.index')));

        $this->actingAs($admin);

        $this->get('/admin/notifications')
            ->assertOk()
            ->assertSee('Pesanan Baru');

        $this->getJson('/admin/notifications/list')
            ->assertOk()
            ->assertJsonPath('unread_count', 1)
            ->assertJsonPath('notifications.0.title', 'Pesanan Baru');

        $this->postJson('/admin/notifications/read')
            ->assertOk()
            ->assertJsonPath('unread_count', 0);

        $this->assertSame(0, $admin->unreadNotifications()->count());
    }
}
