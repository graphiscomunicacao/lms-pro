<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizResult;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizQuizResultsTest extends TestCase
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
    public function it_gets_quiz_quiz_results()
    {
        $quiz = Quiz::factory()->create();
        $quizResults = QuizResult::factory()
            ->count(2)
            ->create([
                'quiz_id' => $quiz->id,
            ]);

        $response = $this->getJson(
            route('api.quizzes.quiz-results.index', $quiz)
        );

        $response->assertOk()->assertSee($quizResults[0]->submited_at);
    }

    /**
     * @test
     */
    public function it_stores_the_quiz_quiz_results()
    {
        $quiz = Quiz::factory()->create();
        $data = QuizResult::factory()
            ->make([
                'quiz_id' => $quiz->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.quizzes.quiz-results.store', $quiz),
            $data
        );

        unset($data['quiz_id']);
        unset($data['user_id']);
        unset($data['submited_at']);
        unset($data['result']);

        $this->assertDatabaseHas('quiz_results', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $quizResult = QuizResult::latest('id')->first();

        $this->assertEquals($quiz->id, $quizResult->quiz_id);
    }
}
