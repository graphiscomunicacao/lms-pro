<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryLearningArtifactsTest extends TestCase
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
    public function it_gets_category_learning_artifacts()
    {
        $category = Category::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $category->learningArtifacts()->attach($learningArtifact);

        $response = $this->getJson(
            route('api.categories.learning-artifacts.index', $category)
        );

        $response->assertOk()->assertSee($learningArtifact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_artifacts_to_category()
    {
        $category = Category::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->postJson(
            route('api.categories.learning-artifacts.store', [
                $category,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $category
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_artifacts_from_category()
    {
        $category = Category::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->deleteJson(
            route('api.categories.learning-artifacts.store', [
                $category,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $category
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }
}
