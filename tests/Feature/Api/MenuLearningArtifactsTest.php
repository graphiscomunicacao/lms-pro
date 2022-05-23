<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuLearningArtifactsTest extends TestCase
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
    public function it_gets_menu_learning_artifacts()
    {
        $menu = Menu::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $menu->learningArtifacts()->attach($learningArtifact);

        $response = $this->getJson(
            route('api.menus.learning-artifacts.index', $menu)
        );

        $response->assertOk()->assertSee($learningArtifact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_learning_artifacts_to_menu()
    {
        $menu = Menu::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->postJson(
            route('api.menus.learning-artifacts.store', [
                $menu,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $menu
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_learning_artifacts_from_menu()
    {
        $menu = Menu::factory()->create();
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->deleteJson(
            route('api.menus.learning-artifacts.store', [
                $menu,
                $learningArtifact,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $menu
                ->learningArtifacts()
                ->where('learning_artifacts.id', $learningArtifact->id)
                ->exists()
        );
    }
}
