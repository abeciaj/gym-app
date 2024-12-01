<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GymMngrTest extends TestCase
{
    public function test_create_displays_create_view()
    {
        $response = $this->get(route('gymManager.create'));
        $response->assertStatus(200);
        $response->assertViewIs('gymManager.create');
    }

    public function test_store_saves_data_and_redirects()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('profile.jpg');
        $data = [
            'name' => 'John Doe',
            'password' => 'password123',
            'email' => 'john@example.com',
            'national_id' => '1234567890',
            'profile_image' => $file,
        ];

        $response = $this->post(route('gymManager.store'), $data);

        $response->assertRedirect(route('gymManager.list'));
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_list_displays_users()
    {
        $response = $this->get(route('gymManager.list'));
        $response->assertStatus(200);
        $response->assertViewIs('gymManager.list');
    }

    public function test_show_displays_user_details()
    {
        $user = User::factory()->create();

        $response = $this->get(route('gymManager.show', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('gymManager.show');
        $response->assertViewHas('singleUser', $user);
    }

    public function test_edit_displays_edit_view()
    {
        $user = User::factory()->create();

        $response = $this->get(route('gymManager.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('gymManager.edit');
    }

    public function test_update_updates_user_and_redirects()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'password' => 'newpassword',
            'email' => $user->email,
            'national_id' => $user->national_id,
        ];

        $response = $this->put(route('gymManager.update', $user->id), $data);

        $response->assertRedirect(route('gymManager.list'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
        ]);
    }

    public function test_delete_removes_user_and_responds_with_success()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('gymManager.deletegymManager', $user->id));

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Record deleted successfully!']);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
