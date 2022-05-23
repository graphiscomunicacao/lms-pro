<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\SupportLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportLinkMenusTest extends TestCase
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
    public function it_gets_support_link_menus()
    {
        $supportLink = SupportLink::factory()->create();
        $menu = Menu::factory()->create();

        $supportLink->menus()->attach($menu);

        $response = $this->getJson(
            route('api.support-links.menus.index', $supportLink)
        );

        $response->assertOk()->assertSee($menu->name);
    }

    /**
     * @test
     */
    public function it_can_attach_menus_to_support_link()
    {
        $supportLink = SupportLink::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->postJson(
            route('api.support-links.menus.store', [$supportLink, $menu])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $supportLink
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_menus_from_support_link()
    {
        $supportLink = SupportLink::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->deleteJson(
            route('api.support-links.menus.store', [$supportLink, $menu])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $supportLink
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }
}
