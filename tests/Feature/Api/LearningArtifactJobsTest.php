<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningArtifactJobsTest extends TestCase
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
    public function it_gets_learning_artifact_jobs()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $job = Job::factory()->create();

        $learningArtifact->jobs()->attach($job);

        $response = $this->getJson(
            route('api.learning-artifacts.jobs.index', $learningArtifact)
        );

        $response->assertOk()->assertSee($job->name);
    }

    /**
     * @test
     */
    public function it_can_attach_jobs_to_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $job = Job::factory()->create();

        $response = $this->postJson(
            route('api.learning-artifacts.jobs.store', [
                $learningArtifact,
                $job,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningArtifact
                ->jobs()
                ->where('jobs.id', $job->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_jobs_from_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $job = Job::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-artifacts.jobs.store', [
                $learningArtifact,
                $job,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningArtifact
                ->jobs()
                ->where('jobs.id', $job->id)
                ->exists()
        );
    }
}
