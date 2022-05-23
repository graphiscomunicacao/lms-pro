<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\SupportLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategorySupportLinksTest extends TestCase
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
    public function it_gets_category_support_links()
    {
        $category = Category::factory()->create();
        $supportLink = SupportLink::factory()->create();

        $category->supportLinks()->attach($supportLink);

        $response = $this->getJson(
            route('api.categories.support-links.index', $category)
        );

        $response->assertOk()->assertSee($supportLink->name);
    }

    /**
     * @test
     */
    public function it_can_attach_support_links_to_category()
    {
        $category = Category::factory()->create();
        $supportLink = SupportLink::factory()->create();

        $response = $this->postJson(
            route('api.categories.support-links.store', [
                $category,
                $supportLink,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $category
                ->supportLinks()
                ->where('support_links.id', $supportLink->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_support_links_from_category()
    {
        $category = Category::factory()->create();
        $supportLink = SupportLink::factory()->create();

        $response = $this->deleteJson(
            route('api.categories.support-links.store', [
                $category,
                $supportLink,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $category
                ->supportLinks()
                ->where('support_links.id', $supportLink->id)
                ->exists()
        );
    }
}
