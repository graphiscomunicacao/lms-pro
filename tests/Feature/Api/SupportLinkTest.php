<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SupportLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportLinkTest extends TestCase
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
    public function it_gets_support_links_list()
    {
        $supportLinks = SupportLink::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.support-links.index'));

        $response->assertOk()->assertSee($supportLinks[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_support_link()
    {
        $data = SupportLink::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.support-links.store'), $data);

        $this->assertDatabaseHas('support_links', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.support-links.update', $supportLink),
            $data
        );

        $data['id'] = $supportLink->id;

        $this->assertDatabaseHas('support_links', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_support_link()
    {
        $supportLink = SupportLink::factory()->create();

        $response = $this->deleteJson(
            route('api.support-links.destroy', $supportLink)
        );

        $this->assertSoftDeleted($supportLink);

        $response->assertNoContent();
    }
}
