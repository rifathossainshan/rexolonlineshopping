<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_loads_with_metrics()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalRevenue',
            'pendingOrders',
            'lowStockCount',
            'recentOrders',
            'recentUsers',
            'dates',
            'salesData'
        ]);
        $response->assertSee('Total Revenue'); // Check for view content
    }
}
