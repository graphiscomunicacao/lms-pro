<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningPath;
use App\Models\LearningPathGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathLearningPathGroupsTest extends TestCase
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
    public function it_gets_learning_path_learning_path_groups()
    {
        $learningPath = LearningPath::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $learningPath->learningPathGroups()->attach($learningPathGroup);

        $response = $this->getJson(
            route(
                'api.learning-paths.learning-path-groups.index',
                $learningPath
            )
        );

        $response->assertOk()->assertSee($learningPathGroup->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_path_groups_to_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $response = $this->postJson(
            route('api.learning-paths.learning-path-groups.store', [
                $learningPath,
                $learningPathGroup,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningPath
                ->learningPathGroups()
                ->where('learning_path_groups.id', $learningPathGroup->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_path_groups_from_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $learningPathGroup = LearningPathGroup::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.learning-path-groups.store', [
                $learningPath,
                $learningPathGroup,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningPath
                ->learningPathGroups()
                ->where('learning_path_groups.id', $learningPathGroup->id)
                ->exists()
        );
    }
}
