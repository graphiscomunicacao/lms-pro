<?php

namespace Tests\Feature\Api;

use App\Models\User;

use App\Models\Job;
use App\Models\Role;
use App\Models\Group;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
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
    public function it_gets_users_list()
    {
        $users = User::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.users.index'));

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user()
    {
        $data = User::factory()
            ->make()
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(route('api.users.store'), $data);

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['two_factor_confirmed_at']);
        unset($data['current_team_id']);
        unset($data['profile_photo_path']);
        unset($data['total_experience']);
        unset($data['user_id']);

        $this->assertDatabaseHas('users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_user()
    {
        $user = User::factory()->create();

        $role = Role::factory()->create();
        $job = Job::factory()->create();
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique->email,
            'total_experience' => $this->faker->randomNumber(0),
            'role_id' => $role->id,
            'job_id' => $job->id,
            'group_id' => $group->id,
            'user_id' => $user->id,
        ];

        $data['password'] = \Str::random('8');

        $response = $this->putJson(route('api.users.update', $user), $data);

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['two_factor_confirmed_at']);
        unset($data['current_team_id']);
        unset($data['profile_photo_path']);
        unset($data['total_experience']);
        unset($data['user_id']);

        $data['id'] = $user->id;

        $this->assertDatabaseHas('users', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(route('api.users.destroy', $user));

        $this->assertSoftDeleted($user);

        $response->assertNoContent();
    }
}
