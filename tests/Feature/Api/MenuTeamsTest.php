<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\Team;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTeamsTest extends TestCase
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
    public function it_gets_menu_teams()
    {
        $menu = Menu::factory()->create();
        $team = Team::factory()->create();

        $menu->teams()->attach($team);

        $response = $this->getJson(route('api.menus.teams.index', $menu));

        $response->assertOk()->assertSee($team->name);
    }

    /**
     * @test
     */
    public function it_can_attach_teams_to_menu()
    {
        $menu = Menu::factory()->create();
        $team = Team::factory()->create();

        $response = $this->postJson(
            route('api.menus.teams.store', [$menu, $team])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $menu
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_teams_from_menu()
    {
        $menu = Menu::factory()->create();
        $team = Team::factory()->create();

        $response = $this->deleteJson(
            route('api.menus.teams.store', [$menu, $team])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $menu
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }
}
