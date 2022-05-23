<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\ObjectiveQuestion;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryObjectiveQuestionsTest extends TestCase
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
    public function it_gets_category_objective_questions()
    {
        $category = Category::factory()->create();
        $objectiveQuestion = ObjectiveQuestion::factory()->create();

        $category->objectiveQuestions()->attach($objectiveQuestion);

        $response = $this->getJson(
            route('api.categories.objective-questions.index', $category)
        );

        $response->assertOk()->assertSee($objectiveQuestion->body);
    }

    /**
     * @test
     */
    public function it_can_attach_objective_questions_to_category()
    {
        $category = Category::factory()->create();
        $objectiveQuestion = ObjectiveQuestion::factory()->create();

        $response = $this->postJson(
            route('api.categories.objective-questions.store', [
                $category,
                $objectiveQuestion,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $category
                ->objectiveQuestions()
                ->where('objective_questions.id', $objectiveQuestion->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_objective_questions_from_category()
    {
        $category = Category::factory()->create();
        $objectiveQuestion = ObjectiveQuestion::factory()->create();

        $response = $this->deleteJson(
            route('api.categories.objective-questions.store', [
                $category,
                $objectiveQuestion,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $category
                ->objectiveQuestions()
                ->where('objective_questions.id', $objectiveQuestion->id)
                ->exists()
        );
    }
}
