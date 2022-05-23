<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizCategoriesTest extends TestCase
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
    public function it_gets_quiz_categories()
    {
        $quiz = Quiz::factory()->create();
        $category = Category::factory()->create();

        $quiz->categories()->attach($category);

        $response = $this->getJson(
            route('api.quizzes.categories.index', $quiz)
        );

        $response->assertOk()->assertSee($category->name);
    }

    /**
     * @test
     */
    public function it_can_attach_categories_to_quiz()
    {
        $quiz = Quiz::factory()->create();
        $category = Category::factory()->create();

        $response = $this->postJson(
            route('api.quizzes.categories.store', [$quiz, $category])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $quiz
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_categories_from_quiz()
    {
        $quiz = Quiz::factory()->create();
        $category = Category::factory()->create();

        $response = $this->deleteJson(
            route('api.quizzes.categories.store', [$quiz, $category])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $quiz
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }
}
