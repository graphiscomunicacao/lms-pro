<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathCategoriesTest extends TestCase
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
    public function it_gets_learning_path_categories()
    {
        $learningPath = LearningPath::factory()->create();
        $category = Category::factory()->create();

        $learningPath->categories()->attach($category);

        $response = $this->getJson(
            route('api.learning-paths.categories.index', $learningPath)
        );

        $response->assertOk()->assertSee($category->name);
    }

    /**
     * @test
     */
    public function it_can_attach_categories_to_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $category = Category::factory()->create();

        $response = $this->postJson(
            route('api.learning-paths.categories.store', [
                $learningPath,
                $category,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningPath
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_categories_from_learning_path()
    {
        $learningPath = LearningPath::factory()->create();
        $category = Category::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.categories.store', [
                $learningPath,
                $category,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningPath
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }
}
