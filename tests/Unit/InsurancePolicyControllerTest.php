<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\InsurancePolicy;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InsurancePolicyControllerTest extends TestCase
{

    use RefreshDatabase;
    // /**
    //  * A basic unit test example.
    //  */
    // public function test_example(): void
    // {
    //     $this->assertTrue(true);
    // }

    public function test_policy_can_be_created()
    {
       // Arrange: Create an authenticated user
       $user = User::factory()->create();
       $this->actingAs($user);

        // Policy data to create
        $policyData = [
            'policy_number' => '123563453',
            'holder_name' => 'abcgfgdg',
            'type_of_insurance' => 'TERM',
            'coverage_amount' => 25000
        ];

        // Act: Hit the API endpoint to create a policy
        $response = $this->postJson('/api/insurancePolicies', $policyData);

        // Assert: Check the response
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Inusrance Policy Create Successful',
                'data' => [
                    'policy_number' => '123563453',
                    'holder_name' => 'abcgfgdg',
                    'type_of_insurance' => 'TERM',
                    'coverage_amount' => 25000
                ],
            ]);
    }

    public function test_all_policies_can_be_viewed()
    {
       // Arrange: Create an authenticated user
       $user = User::factory()->create();
       $this->actingAs($user);

        // Arrange: Create some policies
        InsurancePolicy::factory()->count(3)->create();

        // Act: Hit the API endpoint
        $response = $this->getJson('/api/insurancePolicies');

        // Assert: Check the response
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3, 'data');
    }

    public function test_policy_can_be_viewed()
    {
        // Arrange: Create a policy
        $policy = InsurancePolicy::factory()->create();

        // Act: Hit the API endpoint to create a user
        $response = $this->getJson("/api/insurancePolicies/{$policy->id}");

        // Assert: Check the response
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => $policy->id,
                    'policy_number' => $policy->policy_number,
                    'holder_name' => $policy->holder_name,
                    'type_of_insurance' => $policy->type_of_insurance,
                    'coverage_amount' => $policy->coverage_amount,
                ],
            ]);
    }

    public function test_policy_can_be_updated()
    {
        // Arrange: Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Arrange: Create a policy
        $policy = InsurancePolicy::factory()->create(['user_id' => $user->id]);

        // Policy data to update
        $policyUpdateData = [
            'policy_number' => '123563453',
            'holder_name' => 'abcgfgdg',
            'type_of_insurance' => 'TERM',
            'coverage_amount' => 25000
        ];

        // Act: Hit the API endpoint to update the user
        $response = $this->putJson("/api/insurancePolicies/{$policy->id}", $policyUpdateData);

        // Assert: Check the response
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Insurance Policy Update Successful',
                'data' => [
                    'id' => $policy->id,
                    'policy_number' => '123563453',
                    'holder_name' => 'abcgfgdg',
                    'type_of_insurance' => 'TERM',
                    'coverage_amount' => 25000
                ],
            ]);
    }

    public function test_policy_can_be_deleted()
    {
       // Arrange: Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Arrange: Create a policy
        $policy = InsurancePolicy::factory()->create(['user_id' => $user->id]);

        // Act: Hit the API endpoint to delete the user
        $response = $this->deleteJson("/api/insurancePolicies/{$policy->id}");

        // Assert: Check the response
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
