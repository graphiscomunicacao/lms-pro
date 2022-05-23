<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamLearningPathsTest extends TestCase
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
    public function it_gets_team_learning_paths()
    {
        $team = Team::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $team->learningPaths()->attach($learningPath);

        $response = $this->getJson(
            route('api.teams.learning-paths.index', $team)
        );

        $response->assertOk()->assertSee($learningPath->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_paths_to_team()
    {
        $team = Team::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->postJson(
            route('api.teams.learning-paths.store', [$team, $learningPath])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $team
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_paths_from_team()
    {
        $team = Team::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->deleteJson(
            route('api.teams.learning-paths.store', [$team, $learningPath])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $team
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }
}
