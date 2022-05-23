<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SupportLink;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportLinkControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_support_links()
    {
        $supportLinks = SupportLink::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('support-links.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.support_links.index')
            ->assertViewHas('supportLinks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_support_link()
    {
        $response = $this->get(route('support-links.create'));

        $response->assertOk()->assertViewIs('app.support_links.create');
    }

    /**
     * @test
     */
    public function it_stores_the_support_link()
    {
        $data = SupportLink::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('support-links.store'), $data);

        $this->assertDatabaseHas('support_links', $data);

        $supportLink = SupportLink::latest('id')->first();

        $response->assertRedirect(route('support-links.edit', $supportLink));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_support_link()
    {
        $supportLink = SupportLink::factory()->create();

        $response = $this->get(route('support-links.show', $supportLink));

        $response
            ->assertOk()
            ->assertViewIs('app.support_links.show')
            ->assertViewHas('supportLink');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_support_link()
    {
        $supportLink = SupportLink::factory()->create();

        $response = $this->get(route('support-links.edit', $supportLink));

        $response
            ->assertOk()
            ->assertViewIs('app.support_links.edit')
            ->assertViewHas('supportLink');
    }

    /**
     * @test
     */
    public function it_updates_the_support_link()
    {
        $supportLink = SupportLink::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'url' => $this->faker->url,
            'same_tab' => $this->faker->boolean,
            'cover_path' => $this->faker->text(255),
        ];

        $response = $this->put(
            route('support-links.update', $supportLink),
            $data
        );

        $data['id'] = $supportLink->id;

        $this->assertDatabaseHas('support_links', $data);

        $response->assertRedirect(route('support-links.edit', $supportLink));
    }

    /**
     * @test
     */
    public function it_deletes_the_support_link()
    {
        $supportLink = SupportLink::factory()->create();

        $response = $this->delete(route('support-links.destroy', $supportLink));

        $response->assertRedirect(route('support-links.index'));

        $this->assertSoftDeleted($supportLink);
    }
}
