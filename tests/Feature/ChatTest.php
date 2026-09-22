<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsCustomer(): User
    {
        $customer = User::factory()->customer()->create(['name' => 'Dewi']);

        $this->actingAs($customer);

        return $customer;
    }

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->create(['username' => 'admin', 'role' => 'admin']);

        $this->actingAs($admin);

        return $admin;
    }

    public function test_customer_can_send_message_and_chat_is_created(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/customer/chat/send', ['message' => 'Apakah roti sisir halal?'])
            ->assertCreated()
            ->assertJsonPath('success', true);

        $chat = Chat::firstOrFail();
        $message = $chat->messages()->firstOrFail();

        $this->assertSame(ChatMessage::SENDER_CUSTOMER, $message->sender);
        $this->assertSame('Apakah roti sisir halal?', $message->message);
        $this->assertFalse($message->read_by_admin);
    }

    public function test_customer_send_notifies_admins(): void
    {
        Notification::fake();
        $admin = User::factory()->create(['username' => 'admin', 'role' => 'admin']);
        $this->actingAsCustomer();

        $this->postJson('/customer/chat/send', ['message' => 'Halo admin'])
            ->assertCreated();

        Notification::assertSentTo($admin, AppNotification::class);
    }

    public function test_customer_requires_login_to_send(): void
    {
        $this->postJson('/customer/chat/send', ['message' => 'hi'])
            ->assertStatus(401);
    }

    public function test_admin_sees_chat_with_unread_count(): void
    {
        $customer = User::factory()->customer()->create();
        $chat = Chat::create(['customer_id' => $customer->id, 'last_message_at' => now()]);
        $chat->messages()->create([
            'sender' => ChatMessage::SENDER_CUSTOMER,
            'message' => 'Pertanyaan',
            'read_by_admin' => false,
        ]);

        $this->actingAsAdmin();

        $this->getJson('/admin/chat/overview')
            ->assertOk()
            ->assertJsonPath('total_unread', 1)
            ->assertJsonPath('chats.0.customer_name', $customer->name);

        $response = $this->get('/admin/chat')->assertOk();
        $response->assertSee('Pertanyaan');
    }

    public function test_admin_messages_endpoint_marks_as_read(): void
    {
        $customer = User::factory()->customer()->create();
        $chat = Chat::create(['customer_id' => $customer->id, 'last_message_at' => now()]);
        $chat->messages()->create([
            'sender' => ChatMessage::SENDER_CUSTOMER,
            'message' => 'Bisa kirim besok?',
            'read_by_admin' => false,
        ]);

        $this->actingAsAdmin();

        $this->getJson("/admin/chat/{$chat->id}/messages")
            ->assertOk()
            ->assertJsonCount(1, 'messages');

        $this->assertSame(0, $chat->unreadByAdmin()->count());
    }

    public function test_admin_can_reply_and_notify_customer(): void
    {
        Notification::fake();
        $customer = User::factory()->customer()->create();
        $chat = Chat::create(['customer_id' => $customer->id, 'last_message_at' => now()]);

        $this->actingAsAdmin();

        $this->postJson("/admin/chat/{$chat->id}/send", ['message' => 'Bisa, silakan datang.'])
            ->assertCreated()
            ->assertJsonPath('success', true);

        $message = $chat->messages()->firstOrFail();
        $this->assertSame(ChatMessage::SENDER_ADMIN, $message->sender);
        $this->assertSame('Bisa, silakan datang.', $message->message);

        Notification::assertSentTo($customer, AppNotification::class);
    }

    public function test_customer_poll_returns_new_messages(): void
    {
        $customer = User::factory()->customer()->create();
        $chat = Chat::create(['customer_id' => $customer->id, 'last_message_at' => now()]);
        $first = $chat->messages()->create([
            'sender' => ChatMessage::SENDER_ADMIN,
            'message' => 'Pertama',
            'read_by_customer' => false,
        ]);
        $chat->messages()->create([
            'sender' => ChatMessage::SENDER_ADMIN,
            'message' => 'Kedua',
            'read_by_customer' => false,
        ]);

        $this->actingAs($customer);

        $this->getJson('/customer/chat/poll?after='.$first->id)
            ->assertOk()
            ->assertJsonCount(1, 'messages')
            ->assertJsonPath('messages.0.message', 'Kedua');
    }
}
