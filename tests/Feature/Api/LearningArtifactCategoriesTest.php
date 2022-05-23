<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningArtifactCategoriesTest extends TestCase
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
    public function it_gets_learning_artifact_categories()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $category = Category::factory()->create();

        $learningArtifact->categories()->attach($category);

        $response = $this->getJson(
            route('api.learning-artifacts.categories.index', $learningArtifact)
        );

        $response->assertOk()->assertSee($category->name);
    }

    /**
     * @test
     */
    public function it_can_attach_categories_to_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $category = Category::factory()->create();

        $response = $this->postJson(
            route('api.learning-artifacts.categories.store', [
                $learningArtifact,
                $category,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningArtifact
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_categories_from_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $category = Category::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-artifacts.categories.store', [
                $learningArtifact,
                $category,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningArtifact
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }
}
