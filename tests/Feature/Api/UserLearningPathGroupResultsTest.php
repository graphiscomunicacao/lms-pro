<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningPathGroupResult;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLearningPathGroupResultsTest extends TestCase
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
    public function it_gets_user_learning_path_group_results()
    {
        $user = User::factory()->create();
        $learningPathGroupResults = LearningPathGroupResult::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.learning-path-group-results.index', $user)
        );

        $response->assertOk()->assertSee($learningPathGroupResults[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_learning_path_group_results()
    {
        $user = User::factory()->create();
        $data = LearningPathGroupResult::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.learning-path-group-results.store', $user),
            $data
        );

        unset($data['user_id']);
        unset($data['submited_at']);
        unset($data['score']);
        unset($data['learning_path_group_id']);

        $this->assertDatabaseHas('learning_path_group_results', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $learningPathGroupResult = LearningPathGroupResult::latest(
            'id'
        )->first();

        $this->assertEquals($user->id, $learningPathGroupResult->user_id);
    }
}
