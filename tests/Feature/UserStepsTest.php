<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Gateway;

class UserSteps extends TestCase
{

    use RefreshDatabase;


    public function test_user_can_make_subscription()
    {

        $gateway = Gateway::factory()->create();

        $user = User::factory()->create();

        $braintree = config('braintree');

        $result = $braintree->customer()->create([
            'firstName' => $user->name,
            'email' => $user->email
        ]);

        $user->customer()->create([
            'code' => $result->customer->id,
            'gateway_id' => $gateway->id
        ]);

        $response = $this->actingAs($user, 'api')
         ->post('/api/transaction/make', ['number' => '4111111111111111', 'expirationDate' => '06/22', 'cvv' => '100']);

     $response->assertStatus(200);
     $response->dump();
    }

    public function test_user_can_cancel_subscription()
    {

        $gateway = Gateway::factory()->create();

        $user = User::factory()->create();

        $braintree = config('braintree');

        $result = $braintree->customer()->create([
            'firstName' => $user->name,
            'email' => $user->email
        ]);

        $user->customer()->create([
            'code' => $result->customer->id,
            'gateway_id' => $gateway->id
        ]);

        $response = $this->actingAs($user, 'api')
         ->post('/api/transaction/make', ['number' => '4111111111111111', 'expirationDate' => '06/22', 'cvv' => '100']);

         $response = $this->actingAs($user, 'api')
         ->post('/api/transaction/cancel');

     $response->assertStatus(200);
     $response->dump();
    }

}
