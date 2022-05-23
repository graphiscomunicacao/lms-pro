<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathQuizzesTest extends TestCase
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
    public function it_gets_learning_path_quizzes()
    {
        $learningPath = LearningPath::factory()->create();
        $quiz = Quiz::factory()->create();

        $learningPath->quizzes()->attach($quiz);

        $response = $this->getJson(
            route('api.learning-paths.quizzes.index', $learningPath)
        );

        $response->assertOk()->assertSee($quiz->name);
    }

    /**
     * @test
     */
    public function it_can_attach_quizzes_to_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $quiz = Quiz::factory()->create();

        $response = $this->postJson(
            route('api.learning-paths.quizzes.store', [$learningPath, $quiz])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningPath
                ->quizzes()
                ->where('quizzes.id', $quiz->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_quizzes_from_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $quiz = Quiz::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.quizzes.store', [$learningPath, $quiz])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningPath
                ->quizzes()
                ->where('quizzes.id', $quiz->id)
                ->exists()
        );
    }
}
