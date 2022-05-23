<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ObjectiveAnswer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserObjectiveAnswersTest extends TestCase
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
    public function it_gets_user_objective_answers()
    {
        $user = User::factory()->create();
        $objectiveAnswers = ObjectiveAnswer::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.objective-answers.index', $user)
        );

        $response->assertOk()->assertSee($objectiveAnswers[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_objective_answers()
    {
        $user = User::factory()->create();
        $data = ObjectiveAnswer::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.objective-answers.store', $user),
            $data
        );

        unset($data['user_id']);
        unset($data['objective_question_id']);
        unset($data['objective_question_option_id']);
        unset($data['is_correct']);
        unset($data['time_spent']);

        $this->assertDatabaseHas('objective_answers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $objectiveAnswer = ObjectiveAnswer::latest('id')->first();

        $this->assertEquals($user->id, $objectiveAnswer->user_id);
    }
}
