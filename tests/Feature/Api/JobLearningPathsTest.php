<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobLearningPathsTest extends TestCase
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
    public function it_gets_job_learning_paths()
    {
        $job = Job::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $job->learningPaths()->attach($learningPath);

        $response = $this->getJson(
            route('api.jobs.learning-paths.index', $job)
        );

        $response->assertOk()->assertSee($learningPath->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_paths_to_job()
    {
        $job = Job::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->postJson(
            route('api.jobs.learning-paths.store', [$job, $learningPath])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $job
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_paths_from_job()
    {
        $job = Job::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->deleteJson(
            route('api.jobs.learning-paths.store', [$job, $learningPath])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $job
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }
}
