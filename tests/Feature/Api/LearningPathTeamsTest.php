<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathTeamsTest extends TestCase
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
    public function it_gets_learning_path_teams()
    {
        $learningPath = LearningPath::factory()->create();
        $team = Team::factory()->create();

        $learningPath->teams()->attach($team);

        $response = $this->getJson(
            route('api.learning-paths.teams.index', $learningPath)
        );

        $response->assertOk()->assertSee($team->name);
    }

    /**
     * @test
     */
    public function it_can_attach_teams_to_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $team = Team::factory()->create();

        $response = $this->postJson(
            route('api.learning-paths.teams.store', [$learningPath, $team])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningPath
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_teams_from_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $team = Team::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.teams.store', [$learningPath, $team])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningPath
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }
}
