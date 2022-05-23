<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;
use App\Models\LearningPathGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobLearningPathGroupsTest extends TestCase
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
    public function it_gets_job_learning_path_groups()
    {
        $job = Job::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $job->learningPathGroups()->attach($learningPathGroup);

        $response = $this->getJson(
            route('api.jobs.learning-path-groups.index', $job)
        );

        $response->assertOk()->assertSee($learningPathGroup->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_path_groups_to_job()
    {
        $job = Job::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $response = $this->postJson(
            route('api.jobs.learning-path-groups.store', [
                $job,
                $learningPathGroup,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $job
                ->learningPathGroups()
                ->where('learning_path_groups.id', $learningPathGroup->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_path_groups_from_job()
    {
        $job = Job::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $response = $this->deleteJson(
            route('api.jobs.learning-path-groups.store', [
                $job,
                $learningPathGroup,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $job
                ->learningPathGroups()
                ->where('learning_path_groups.id', $learningPathGroup->id)
                ->exists()
        );
    }
}
