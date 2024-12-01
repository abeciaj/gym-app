<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoachTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_displays_coaches()
    {
        User::factory()->role('coach')->count(3)->create();

        $response = $this->get(route('coach.list'));

        $response->assertStatus(200);
        $response->assertViewHas('coaches');
    }

    public function test_store_creates_coach()
    {
        $data = [
            'name' => 'Test Coach',
            'email' => 'coach@test.com',
            'city_id' => 1,
        ];

        $response = $this->post(route('coach.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    public function test_delete_removes_coach()
    {
        $coach = User::factory()->role('coach')->create();

        $response = $this->delete(route('coach.delete', $coach->id));

        $response->assertJson(['success' => 'Record deleted successfully!']);
        $this->assertSoftDeleted($coach);
    }
}
