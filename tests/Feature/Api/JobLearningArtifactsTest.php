<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobLearningArtifactsTest extends TestCase
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
    public function it_gets_job_learning_artifacts()
    {
        $job = Job::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $job->learningArtifacts()->attach($learningArtifact);

        $response = $this->getJson(
            route('api.jobs.learning-artifacts.index', $job)
        );

        $response->assertOk()->assertSee($learningArtifact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_artifacts_to_job()
    {
        $job = Job::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->postJson(
            route('api.jobs.learning-artifacts.store', [
                $job,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $job
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_artifacts_from_job()
    {
        $job = Job::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->deleteJson(
            route('api.jobs.learning-artifacts.store', [
                $job,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $job
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }
}
