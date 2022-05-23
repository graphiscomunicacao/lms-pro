<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizLearningPathsTest extends TestCase
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
    public function it_gets_quiz_learning_paths()
    {
        $quiz = Quiz::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $quiz->learningPaths()->attach($learningPath);

        $response = $this->getJson(
            route('api.quizzes.learning-paths.index', $quiz)
        );

        $response->assertOk()->assertSee($learningPath->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_paths_to_quiz()
    {
        $quiz = Quiz::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->postJson(
            route('api.quizzes.learning-paths.store', [$quiz, $learningPath])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $quiz
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_paths_from_quiz()
    {
        $quiz = Quiz::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->deleteJson(
            route('api.quizzes.learning-paths.store', [$quiz, $learningPath])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $quiz
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }
}
