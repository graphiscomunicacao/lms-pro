<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SupportLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSupportLinksTest extends TestCase
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
    public function it_gets_user_support_links()
    {
        $user = User::factory()->create();
        $supportLinks = SupportLink::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.support-links.index', $user)
        );

        $response->assertOk()->assertSee($supportLinks[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_support_links()
    {
        $user = User::factory()->create();
        $data = SupportLink::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.support-links.store', $user),
            $data
        );

        unset($data['cover_path']);

        $this->assertDatabaseHas('support_links', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $supportLink = SupportLink::latest('id')->first();

        $this->assertEquals($user->id, $supportLink->user_id);
    }
}
