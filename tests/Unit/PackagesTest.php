<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TrainingPackage;

class PackagesTest extends TestCase
{
    public function test_index_displays_packages()
    {
        $response = $this->get(route('trainingPackages.listPackages'));

        $response->assertStatus(200);
        $response->assertViewIs('trainingPackages.listPackages');
    }

    public function test_store_saves_package_and_redirects()
    {
        $data = [
            'name' => 'Starter Package',
            'price' => 50,
            'sessions_number' => 5,
        ];

        $response = $this->post(route('trainingPackages.store'), $data);

        $response->assertRedirect(route('trainingPackages.listPackages'));
        $this->assertDatabaseHas('training_packages', ['name' => 'Starter Package']);
    }
}
