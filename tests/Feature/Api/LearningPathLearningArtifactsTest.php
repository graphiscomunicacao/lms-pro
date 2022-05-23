<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningPath;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathLearningArtifactsTest extends TestCase
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
    public function it_gets_learning_path_learning_artifacts()
    {
        $learningPath = LearningPath::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $learningPath->learningArtifacts()->attach($learningArtifact);

        $response = $this->getJson(
            route('api.learning-paths.learning-artifacts.index', $learningPath)
        );

        $response->assertOk()->assertSee($learningArtifact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_artifacts_to_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->postJson(
            route('api.learning-paths.learning-artifacts.store', [
                $learningPath,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningPath
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_artifacts_from_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.learning-artifacts.store', [
                $learningPath,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningPath
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }
}
