<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Menu;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizMenusTest extends TestCase
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
    public function it_gets_quiz_menus()
    {
        $quiz = Quiz::factory()->create();
        $menu = Menu::factory()->create();

        $quiz->menus()->attach($menu);

        $response = $this->getJson(route('api.quizzes.menus.index', $quiz));

        $response->assertOk()->assertSee($menu->name);
    }

    /**
     * @test
     */
    public function it_can_attach_menus_to_quiz()
    {
        $quiz = Quiz::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->postJson(
            route('api.quizzes.menus.store', [$quiz, $menu])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $quiz
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_menus_from_quiz()
    {
        $quiz = Quiz::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->deleteJson(
            route('api.quizzes.menus.store', [$quiz, $menu])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $quiz
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }
}
