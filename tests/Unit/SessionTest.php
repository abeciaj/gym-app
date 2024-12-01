<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TrainingSession;

class SessionTest extends TestCase
{
    public function test_index_displays_training_sessions()
    {
        $response = $this->get(route('TrainingSessions.listSessions'));
        $response->assertStatus(200);
        $response->assertViewIs('TrainingSessions.listSessions');
    }

    public function test_store_saves_session_and_redirects()
    {
        $data = [
            'name' => 'Yoga Session',
            'day' => now()->addDays(1)->toDateString(),
            'starts_at' => '10:00:00',
            'finishes_at' => '11:00:00',
        ];

        $response = $this->post(route('TrainingSessions.store'), $data);

        $response->assertRedirect(route('TrainingSessions.listSessions'));
        $this->assertDatabaseHas('training_sessions', ['name' => 'Yoga Session']);
    }
}
