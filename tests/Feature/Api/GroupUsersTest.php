<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Group;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupUsersTest extends TestCase
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
    public function it_gets_group_users()
    {
        $group = Group::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'group_id' => $group->id,
            ]);

        $response = $this->getJson(route('api.groups.users.index', $group));

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_group_users()
    {
        $group = Group::factory()->create();
        $data = User::factory()
            ->make([
                'group_id' => $group->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.groups.users.store', $group),
            $data
        );

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

        $this->assertEquals($group->id, $user->group_id);
    }
}
