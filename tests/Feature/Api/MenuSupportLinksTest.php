<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\SupportLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuSupportLinksTest extends TestCase
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
    public function it_gets_menu_support_links()
    {
        $menu = Menu::factory()->create();
        $supportLink = SupportLink::factory()->create();

        $menu->supportLinks()->attach($supportLink);

        $response = $this->getJson(
            route('api.menus.support-links.index', $menu)
        );

        $response->assertOk()->assertSee($supportLink->name);
    }

    /**
     * @test
     */
    public function it_can_attach_support_links_to_menu()
    {
        $menu = Menu::factory()->create();
        $supportLink = SupportLink::factory()->create();

        $response = $this->postJson(
            route('api.menus.support-links.store', [$menu, $supportLink])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $menu
                ->supportLinks()
                ->where('support_links.id', $supportLink->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_support_links_from_menu()
    {
        $menu = Menu::factory()->create();
        $supportLink = SupportLink::factory()->create();

        $response = $this->deleteJson(
            route('api.menus.support-links.store', [$menu, $supportLink])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $menu
                ->supportLinks()
                ->where('support_links.id', $supportLink->id)
                ->exists()
        );
    }
}
