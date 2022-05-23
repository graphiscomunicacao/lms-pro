<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamUsersTest extends TestCase
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
    public function it_gets_team_users()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();

        $team->users()->attach($user);

        $response = $this->getJson(route('api.teams.users.index', $team));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_team()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.teams.users.store', [$team, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $team
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_team()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.teams.users.store', [$team, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $team
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
