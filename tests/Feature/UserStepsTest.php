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

        $braintree = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'knxt7b49dt53bwtx',
            'publicKey' => 'x464fs35n6s9prt9',
            'privateKey' => '5af38d67bae3bedb8c2bc41aeae85a06'
        ]);

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

        $braintree = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'knxt7b49dt53bwtx',
            'publicKey' => 'x464fs35n6s9prt9',
            'privateKey' => '5af38d67bae3bedb8c2bc41aeae85a06'
        ]);

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
