<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_paginated_users_list()
    {
        User::factory()->count(15)->create(['name   ' => 'user']);
        
        $response = $this->get('/users/list');
        
        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    /** @test */
    public function it_filters_users_based_on_search_query()
    {
        User::factory()->create(['name' => 'John Doe', 'role' => 'user']);
        User::factory()->create(['name' => 'Jane Doe', 'role' => 'user']);
        
        $response = $this->get('/users/list?search=John');
        
        $response->assertStatus(200);
        $response->assertViewHas('users', function ($users) {
            return $users->count() === 1 && $users->first()->name === 'John Doe';
        });
    }

    /** @test */
    public function it_returns_empty_view_if_no_users_and_no_search()
    {
        $response = $this->get('/users/list');
        $response->assertStatus(200);
        $response->assertViewIs('empty');
    }

    /** @test */
public function it_displays_a_single_user()
{
    $user = User::factory()->create();

    $response = $this->get("/users/show/{$user->id}");

    $response->assertStatus(200);
    $response->assertViewHas('singleUser', $user);
}

/** @test */
public function it_deletes_a_user()
{
    $user = User::factory()->create();

    $response = $this->delete("/users/delete/{$user->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
}

/** @test */
public function it_displays_add_gym_view_with_user_and_gyms()
{
    $user = User::factory()->create();
    Gym::factory()->count(3)->create();

    $response = $this->get("/users/{$user->id}/add-gym");

    $response->assertStatus(200);
    $response->assertViewHas('user', $user);
    $response->assertViewHas('gyms');
}

/** @test */
public function it_assigns_gym_to_user()
{
    $user = User::factory()->create();
    $gym = Gym::factory()->create();

    $response = $this->post("/users/{$user->id}/submit-gym", ['gym_id' => $gym->id]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', ['id' => $user->id, 'gym_id' => $gym->id]);
}

}