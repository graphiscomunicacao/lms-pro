<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;
use App\Models\Menu;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamMenusTest extends TestCase
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
    public function it_gets_team_menus()
    {
        $team = Team::factory()->create();
        $menu = Menu::factory()->create();

        $team->menus()->attach($menu);

        $response = $this->getJson(route('api.teams.menus.index', $team));

        $response->assertOk()->assertSee($menu->name);
    }

    /**
     * @test
     */
    public function it_can_attach_menus_to_team()
    {
        $team = Team::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->postJson(
            route('api.teams.menus.store', [$team, $menu])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $team
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_menus_from_team()
    {
        $team = Team::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->deleteJson(
            route('api.teams.menus.store', [$team, $menu])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $team
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }
}
