<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Achievement;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAchievementsTest extends TestCase
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
    public function it_gets_user_achievements()
    {
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create();

        $user->achievements()->attach($achievement);

        $response = $this->getJson(
            route('api.users.achievements.index', $user)
        );

        $response->assertOk()->assertSee($achievement->name);
    }

    /**
     * @test
     */
    public function it_can_attach_achievements_to_user()
    {
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create();

        $response = $this->postJson(
            route('api.users.achievements.store', [$user, $achievement])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->achievements()
                ->where('achievements.id', $achievement->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_achievements_from_user()
    {
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create();

        $response = $this->deleteJson(
            route('api.users.achievements.store', [$user, $achievement])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->achievements()
                ->where('achievements.id', $achievement->id)
                ->exists()
        );
    }
}
