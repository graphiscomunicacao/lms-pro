<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningArtifactMenusTest extends TestCase
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
    public function it_gets_learning_artifact_menus()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $menu = Menu::factory()->create();

        $learningArtifact->menus()->attach($menu);

        $response = $this->getJson(
            route('api.learning-artifacts.menus.index', $learningArtifact)
        );

        $response->assertOk()->assertSee($menu->name);
    }

    /**
     * @test
     */
    public function it_can_attach_menus_to_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->postJson(
            route('api.learning-artifacts.menus.store', [
                $learningArtifact,
                $menu,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $learningArtifact
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_menus_from_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-artifacts.menus.store', [
                $learningArtifact,
                $menu,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $learningArtifact
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }
}
