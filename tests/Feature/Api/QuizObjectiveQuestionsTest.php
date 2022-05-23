<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;
use App\Models\ObjectiveQuestion;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizObjectiveQuestionsTest extends TestCase
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
    public function it_gets_quiz_objective_questions()
    {
        $quiz = Quiz::factory()->create();
        $objectiveQuestion = ObjectiveQuestion::factory()->create();

        $quiz->objectiveQuestions()->attach($objectiveQuestion);

        $response = $this->getJson(
            route('api.quizzes.objective-questions.index', $quiz)
        );

        $response->assertOk()->assertSee($objectiveQuestion->body);
    }

    /**
     * @test
     */
    public function it_can_attach_objective_questions_to_quiz()
    {
        $quiz = Quiz::factory()->create();
        $objectiveQuestion = ObjectiveQuestion::factory()->create();

        $response = $this->postJson(
            route('api.quizzes.objective-questions.store', [
                $quiz,
                $objectiveQuestion,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $quiz
                ->objectiveQuestions()
                ->where('objective_questions.id', $objectiveQuestion->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_objective_questions_from_quiz()
    {
        $quiz = Quiz::factory()->create();
        $objectiveQuestion = ObjectiveQuestion::factory()->create();

        $response = $this->deleteJson(
            route('api.quizzes.objective-questions.store', [
                $quiz,
                $objectiveQuestion,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $quiz
                ->objectiveQuestions()
                ->where('objective_questions.id', $objectiveQuestion->id)
                ->exists()
        );
    }
}
