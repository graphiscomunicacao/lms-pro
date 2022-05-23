<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\SupportLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportLinkCategoriesTest extends TestCase
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
    public function it_gets_support_link_categories()
    {
        $supportLink = SupportLink::factory()->create();
        $category = Category::factory()->create();

        $supportLink->categories()->attach($category);

        $response = $this->getJson(
            route('api.support-links.categories.index', $supportLink)
        );

        $response->assertOk()->assertSee($category->name);
    }

    /**
     * @test
     */
    public function it_can_attach_categories_to_support_link()
    {
        $supportLink = SupportLink::factory()->create();
        $category = Category::factory()->create();

        $response = $this->postJson(
            route('api.support-links.categories.store', [
                $supportLink,
                $category,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $supportLink
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_categories_from_support_link()
    {
        $supportLink = SupportLink::factory()->create();
        $category = Category::factory()->create();

        $response = $this->deleteJson(
            route('api.support-links.categories.store', [
                $supportLink,
                $category,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $supportLink
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }
}
