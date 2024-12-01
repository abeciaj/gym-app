<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_displays_cities()
    {
        City::factory()->count(3)->create();

        $response = $this->get(route('city.list'));

        $response->assertStatus(200);
        $response->assertViewHas('allCities');
    }

    public function test_show_displays_city_data()
    {
        $city = City::factory()->create();

        $response = $this->get(route('city.show', $city->id));

        $response->assertStatus(200);
        $response->assertViewHas('revenueInDollars');
    }

    public function test_store_creates_city()
    {
        $data = City::factory()->make()->toArray();

        $response = $this->post(route('city.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('cities', ['name' => $data['name']]);
    }

    public function test_destroy_deletes_city()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('city.destroy', $city->id));

        $response->assertRedirect();
        $this->assertSoftDeleted($city);
    }
}
