<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamLearningArtifactsTest extends TestCase
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
    public function it_gets_team_learning_artifacts()
    {
        $team = Team::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $team->learningArtifacts()->attach($learningArtifact);

        $response = $this->getJson(
            route('api.teams.learning-artifacts.index', $team)
        );

        $response->assertOk()->assertSee($learningArtifact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_artifacts_to_team()
    {
        $team = Team::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->postJson(
            route('api.teams.learning-artifacts.store', [
                $team,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $team
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_artifacts_from_team()
    {
        $team = Team::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->deleteJson(
            route('api.teams.learning-artifacts.store', [
                $team,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $team
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }
}
