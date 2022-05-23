<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Role;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleUsersTest extends TestCase
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
    public function it_gets_role_users()
    {
        $role = Role::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'role_id' => $role->id,
            ]);

        $response = $this->getJson(route('api.roles.users.index', $role));

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_role_users()
    {
        $role = Role::factory()->create();
        $data = User::factory()
            ->make([
                'role_id' => $role->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.roles.users.store', $role),
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

        $this->assertEquals($role->id, $user->role_id);
    }
}
