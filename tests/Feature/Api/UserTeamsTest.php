<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTeamsTest extends TestCase
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
    public function it_gets_user_teams()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $user->teams()->attach($team);

        $response = $this->getJson(route('api.users.teams.index', $user));

        $response->assertOk()->assertSee($team->name);
    }

    /**
     * @test
     */
    public function it_can_attach_teams_to_user()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $response = $this->postJson(
            route('api.users.teams.store', [$user, $team])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_teams_from_user()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $response = $this->deleteJson(
            route('api.users.teams.store', [$user, $team])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }
}
