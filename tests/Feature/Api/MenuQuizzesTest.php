<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\Quiz;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuQuizzesTest extends TestCase
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
    public function it_gets_menu_quizzes()
    {
        $menu = Menu::factory()->create();
        $quiz = Quiz::factory()->create();

        $menu->quizzes()->attach($quiz);

        $response = $this->getJson(route('api.menus.quizzes.index', $menu));

        $response->assertOk()->assertSee($quiz->name);
    }

    /**
     * @test
     */
    public function it_can_attach_quizzes_to_menu()
    {
        $menu = Menu::factory()->create();
        $quiz = Quiz::factory()->create();

        $response = $this->postJson(
            route('api.menus.quizzes.store', [$menu, $quiz])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $menu
                ->quizzes()
                ->where('quizzes.id', $quiz->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_quizzes_from_menu()
    {
        $menu = Menu::factory()->create();
        $quiz = Quiz::factory()->create();

        $response = $this->deleteJson(
            route('api.menus.quizzes.store', [$menu, $quiz])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $menu
                ->quizzes()
                ->where('quizzes.id', $quiz->id)
                ->exists()
        );
    }
}
