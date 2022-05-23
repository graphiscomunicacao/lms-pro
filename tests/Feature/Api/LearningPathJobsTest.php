<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathJobsTest extends TestCase
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
    public function it_gets_learning_path_jobs()
    {
        $learningPath = LearningPath::factory()->create();
        $job = Job::factory()->create();

        $learningPath->jobs()->attach($job);

        $response = $this->getJson(
            route('api.learning-paths.jobs.index', $learningPath)
        );

        $response->assertOk()->assertSee($job->name);
    }

    /**
     * @test
     */
    public function it_can_attach_jobs_to_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $job = Job::factory()->create();

        $response = $this->postJson(
            route('api.learning-paths.jobs.store', [$learningPath, $job])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningPath
                ->jobs()
                ->where('jobs.id', $job->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_jobs_from_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $job = Job::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.jobs.store', [$learningPath, $job])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningPath
                ->jobs()
                ->where('jobs.id', $job->id)
                ->exists()
        );
    }
}
