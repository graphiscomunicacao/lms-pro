<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLearningArtifactsTest extends TestCase
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
    public function it_gets_user_learning_artifacts()
    {
        $user = User::factory()->create();
        $learningArtifacts = LearningArtifact::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.learning-artifacts.index', $user)
        );

        $response->assertOk()->assertSee($learningArtifacts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_learning_artifacts()
    {
        $user = User::factory()->create();
        $data = LearningArtifact::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.learning-artifacts.store', $user),
            $data
        );

        unset($data['cover_path']);

        $this->assertDatabaseHas('learning_artifacts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $learningArtifact = LearningArtifact::latest('id')->first();

        $this->assertEquals($user->id, $learningArtifact->user_id);
    }
}
