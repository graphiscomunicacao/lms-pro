<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Team;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_teams()
    {
        $teams = Team::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('teams.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.teams.index')
            ->assertViewHas('teams');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_team()
    {
        $response = $this->get(route('teams.create'));

        $response->assertOk()->assertViewIs('app.teams.create');
    }

    /**
     * @test
     */
    public function it_stores_the_team()
    {
        $data = Team::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('teams.store'), $data);

        $this->assertDatabaseHas('teams', $data);

        $team = Team::latest('id')->first();

        $response->assertRedirect(route('teams.edit', $team));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_team()
    {
        $team = Team::factory()->create();

        $response = $this->get(route('teams.show', $team));

        $response
            ->assertOk()
            ->assertViewIs('app.teams.show')
            ->assertViewHas('team');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_team()
    {
        $team = Team::factory()->create();

        $response = $this->get(route('teams.edit', $team));

        $response
            ->assertOk()
            ->assertViewIs('app.teams.edit')
            ->assertViewHas('team');
    }

    /**
     * @test
     */
    public function it_updates_the_team()
    {
        $team = Team::factory()->create();

        $data = [
            'name' => $this->faker->word,
        ];

        $response = $this->put(route('teams.update', $team), $data);

        $data['id'] = $team->id;

        $this->assertDatabaseHas('teams', $data);

        $response->assertRedirect(route('teams.edit', $team));
    }

    /**
     * @test
     */
    public function it_deletes_the_team()
    {
        $team = Team::factory()->create();

        $response = $this->delete(route('teams.destroy', $team));

        $response->assertRedirect(route('teams.index'));

        $this->assertModelMissing($team);
    }
}
