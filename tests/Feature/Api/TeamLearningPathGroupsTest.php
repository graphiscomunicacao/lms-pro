<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Team;
use App\Models\LearningPathGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamLearningPathGroupsTest extends TestCase
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
    public function it_gets_team_learning_path_groups()
    {
        $team = Team::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $team->learningPathGroups()->attach($learningPathGroup);

        $response = $this->getJson(
            route('api.teams.learning-path-groups.index', $team)
        );

        $response->assertOk()->assertSee($learningPathGroup->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_path_groups_to_team()
    {
        $team = Team::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $response = $this->postJson(
            route('api.teams.learning-path-groups.store', [
                $team,
                $learningPathGroup,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $team
                ->learningPathGroups()
                ->where('learning_path_groups.id', $learningPathGroup->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_path_groups_from_team()
    {
        $team = Team::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $response = $this->deleteJson(
            route('api.teams.learning-path-groups.store', [
                $team,
                $learningPathGroup,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $team
                ->learningPathGroups()
                ->where('learning_path_groups.id', $learningPathGroup->id)
                ->exists()
        );
    }
}
