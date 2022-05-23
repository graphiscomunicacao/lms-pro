<?php

namespace Tests\Feature\Api;

use App\Models\User;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUsersTest extends TestCase
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
    public function it_gets_user_users()
    {
        $user = User::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.users.index', $user));

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_users()
    {
        $user = User::factory()->create();
        $data = User::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.users.users.store', $user),
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

        $this->assertEquals($user->id, $user->user_id);
    }
}
