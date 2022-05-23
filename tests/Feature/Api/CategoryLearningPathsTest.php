<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryLearningPathsTest extends TestCase
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
    public function it_gets_category_learning_paths()
    {
        $category = Category::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $category->learningPaths()->attach($learningPath);

        $response = $this->getJson(
            route('api.categories.learning-paths.index', $category)
        );

        $response->assertOk()->assertSee($learningPath->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_paths_to_category()
    {
        $category = Category::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->postJson(
            route('api.categories.learning-paths.store', [
                $category,
                $learningPath,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $category
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_paths_from_category()
    {
        $category = Category::factory()->create();
        $learningPath = LearningPath::factory()->create();

        $response = $this->deleteJson(
            route('api.categories.learning-paths.store', [
                $category,
                $learningPath,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $category
                ->learningPaths()
                ->where('learning_paths.id', $learningPath->id)
                ->exists()
        );
    }
}
