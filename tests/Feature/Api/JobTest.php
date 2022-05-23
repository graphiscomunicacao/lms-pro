<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobTest extends TestCase
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
    public function it_gets_jobs_list()
    {
        $jobs = Job::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.jobs.index'));

        $response->assertOk()->assertSee($jobs[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_job()
    {
        $data = Job::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.jobs.store'), $data);

        $this->assertDatabaseHas('jobs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_job()
    {
        $job = Job::factory()->create();

        $data = [
            'name' => $this->faker->word,
        ];

        $response = $this->putJson(route('api.jobs.update', $job), $data);

        $data['id'] = $job->id;

        $this->assertDatabaseHas('jobs', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_job()
    {
        $job = Job::factory()->create();

        $response = $this->deleteJson(route('api.jobs.destroy', $job));

        $this->assertModelMissing($job);

        $response->assertNoContent();
    }
}
