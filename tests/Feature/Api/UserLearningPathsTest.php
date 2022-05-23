<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLearningPathsTest extends TestCase
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
    public function it_gets_user_learning_paths()
    {
        $user = User::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $user->learningPaths()->attach($learningPath);

        $response = $this->getJson(
            route('api.users.learning-paths.index', $user)
        );

        $response->assertOk()->assertSee($learningPath->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_paths_to_user()
    {
        $user = User::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->postJson(
            route('api.users.learning-paths.store', [$user, $learningPath])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_paths_from_user()
    {
        $user = User::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->deleteJson(
            route('api.users.learning-paths.store', [$user, $learningPath])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }
}
