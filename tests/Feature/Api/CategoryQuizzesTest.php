<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryQuizzesTest extends TestCase
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
    public function it_gets_category_quizzes()
    {
        $category = Category::factory()->create();
        $quiz = Quiz::factory()->create();

        $category->quizzes()->attach($quiz);

        $response = $this->getJson(
            route('api.categories.quizzes.index', $category)
        );

        $response->assertOk()->assertSee($quiz->name);
    }

    /**
     * @test
     */
    public function it_can_attach_quizzes_to_category()
    {
        $category = Category::factory()->create();
        $quiz = Quiz::factory()->create();

        $response = $this->postJson(
            route('api.categories.quizzes.store', [$category, $quiz])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $category
                ->quizzes()
                ->where('quizzes.id', $quiz->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_quizzes_from_category()
    {
        $category = Category::factory()->create();
        $quiz = Quiz::factory()->create();

        $response = $this->deleteJson(
            route('api.categories.quizzes.store', [$category, $quiz])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $category
                ->quizzes()
                ->where('quizzes.id', $quiz->id)
                ->exists()
        );
    }
}
