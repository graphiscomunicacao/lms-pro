<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\QuizResult;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserQuizResultsTest extends TestCase
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
    public function it_gets_user_quiz_results()
    {
        $user = User::factory()->create();
        $quizResults = QuizResult::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.quiz-results.index', $user)
        );

        $response->assertOk()->assertSee($quizResults[0]->submited_at);
    }

    /**
     * @test
     */
    public function it_stores_the_user_quiz_results()
    {
        $user = User::factory()->create();
        $data = QuizResult::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.quiz-results.store', $user),
            $data
        );

        unset($data['quiz_id']);
        unset($data['user_id']);
        unset($data['submited_at']);
        unset($data['result']);

        $this->assertDatabaseHas('quiz_results', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $quizResult = QuizResult::latest('id')->first();

        $this->assertEquals($user->id, $quizResult->user_id);
    }
}
