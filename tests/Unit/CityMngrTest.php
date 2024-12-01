<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityMngrTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_displays_city_managers()
    {
        User::factory()->role('cityManager')->count(3)->create();

        $response = $this->get(route('cityManager.list'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    public function test_store_creates_city_manager()
    {
        $data = [
            'name' => 'Test Manager',
            'email' => 'manager@test.com',
            'password' => 'password123',
            'national_id' => '1234567890',
        ];

        $response = $this->post(route('cityManager.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    public function test_delete_removes_city_manager()
    {
        $user = User::factory()->role('cityManager')->create();

        $response = $this->delete(route('cityManager.delete', $user->id));

        $response->assertJson(['success' => 'Record deleted successfully!']);
        $this->assertSoftDeleted($user);
    }
}
