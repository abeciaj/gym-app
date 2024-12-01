<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Gym;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GymTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_displays_gyms()
    {
        Gym::factory()->count(3)->create();

        $response = $this->get(route('gym.list'));

        $response->assertStatus(200);
        $response->assertViewHas('gyms');
    }

    public function test_store_creates_gym()
    {
        $data = Gym::factory()->make()->toArray();

        $response = $this->post(route('gym.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('gyms', ['name' => $data['name']]);
    }

    public function test_delete_removes_gym()
    {
        $gym = Gym::factory()->create();

        $response = $this->delete(route('gym.delete', $gym->id));

        $response->assertJson(['success' => 'Record deleted successfully!']);
        $this->assertSoftDeleted($gym);
    }
}
