<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SimpleReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_reports_page_can_be_accessed_by_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/reports');

        $response->assertStatus(200);
        $response->assertSee('Reports & Exports');
    }
}
