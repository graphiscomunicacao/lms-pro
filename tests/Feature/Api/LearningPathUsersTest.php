<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathUsersTest extends TestCase
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
    public function it_gets_learning_path_users()
    {
        $learningPath = LearningPath::factory()->create();
        $user = User::factory()->create();

        $learningPath->users()->attach($user);

        $response = $this->getJson(
            route('api.learning-paths.users.index', $learningPath)
        );

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.learning-paths.users.store', [$learningPath, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningPath
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.users.store', [$learningPath, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningPath
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
