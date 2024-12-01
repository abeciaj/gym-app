<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\TrainingPackage;

class PaymentTest extends TestCase
{
    public function test_stripe_view_loads_correctly()
    {
        $response = $this->get(route('stripe'));
        $response->assertStatus(200);
        $response->assertViewIs('PaymentPackage.stripe');
    }

    public function test_index_displays_revenues()
    {
        $response = $this->get(route('PaymentPackage.purchase_history'));

        $response->assertStatus(200);
        $response->assertViewIs('PaymentPackage.purchase_history');
    }
}
