<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_mark_notifications_as_read()
    {
        // 1. Create User
        $user = User::factory()->create();

        // 2. Create Order & Notification
        $order = new Order(['id' => 999, 'status' => 'shipped', 'total_amount' => 100]);
        $order->setRelation('user', $user);

        $user->notify(new OrderStatusUpdated($order));

        // Verify notification exists and is unread
        $this->assertEquals(1, $user->unreadNotifications()->count());

        // 3. Hit the endpoint
        $response = $this->actingAs($user)
            ->postJson(route('notifications.markRead'));

        // 4. Verify response and database
        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }
}
