<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobUsersTest extends TestCase
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
    public function it_gets_job_users()
    {
        $job = Job::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'job_id' => $job->id,
            ]);

        $response = $this->getJson(route('api.jobs.users.index', $job));

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_job_users()
    {
        $job = Job::factory()->create();
        $data = User::factory()
            ->make([
                'job_id' => $job->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(route('api.jobs.users.store', $job), $data);

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['two_factor_confirmed_at']);
        unset($data['current_team_id']);
        unset($data['profile_photo_path']);
        unset($data['total_experience']);
        unset($data['user_id']);

        $this->assertDatabaseHas('users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $user = User::latest('id')->first();

        $this->assertEquals($job->id, $user->job_id);
    }
}
