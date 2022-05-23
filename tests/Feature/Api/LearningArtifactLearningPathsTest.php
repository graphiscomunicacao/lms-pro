<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningPath;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningArtifactLearningPathsTest extends TestCase
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
    public function it_gets_learning_artifact_learning_paths()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $learningArtifact->learningPaths()->attach($learningPath);

        $response = $this->getJson(
            route(
                'api.learning-artifacts.learning-paths.index',
                $learningArtifact
            )
        );

        $response->assertOk()->assertSee($learningPath->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_paths_to_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->postJson(
            route('api.learning-artifacts.learning-paths.store', [
                $learningArtifact,
                $learningPath,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningArtifact
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_paths_from_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-artifacts.learning-paths.store', [
                $learningArtifact,
                $learningPath,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningArtifact
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }
}
