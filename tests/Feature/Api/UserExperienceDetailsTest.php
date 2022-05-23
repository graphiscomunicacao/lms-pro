<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ExperienceDetail;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserExperienceDetailsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_user_experience_details()
    {
        $user = User::factory()->create();
        $experienceDetails = ExperienceDetail::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.experience-details.index', $user)
        );

        $response->assertOk()->assertSee($experienceDetails[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_experience_details()
    {
        $user = User::factory()->create();
        $data = ExperienceDetail::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.experience-details.store', $user),
            $data
        );

        unset($data['user_id']);
        unset($data['experience_amount']);
        unset($data['is_double']);
        unset($data['type']);
        unset($data['item_id']);

        $this->assertDatabaseHas('experience_details', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $experienceDetail = ExperienceDetail::latest('id')->first();

        $this->assertEquals($user->id, $experienceDetail->user_id);
    }
}
