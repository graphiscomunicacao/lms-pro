<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningArtifactTeamsTest extends TestCase
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
    public function it_gets_learning_artifact_teams()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $team = Team::factory()->create();

        $learningArtifact->teams()->attach($team);

        $response = $this->getJson(
            route('api.learning-artifacts.teams.index', $learningArtifact)
        );

        $response->assertOk()->assertSee($team->name);
    }

    /**
     * @test
     */
    public function it_can_attach_teams_to_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $team = Team::factory()->create();

        $response = $this->postJson(
            route('api.learning-artifacts.teams.store', [
                $learningArtifact,
                $team,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningArtifact
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_teams_from_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $team = Team::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-artifacts.teams.store', [
                $learningArtifact,
                $team,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningArtifact
                ->teams()
                ->where('teams.id', $team->id)
                ->exists()
        );
    }
}
