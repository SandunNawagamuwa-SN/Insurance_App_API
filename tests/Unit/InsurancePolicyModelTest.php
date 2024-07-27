<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\InsurancePolicy;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InsurancePolicyModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function a_insurance_policy_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $insurancePolicy = InsurancePolicy::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $insurancePolicy->user);
    }
}
