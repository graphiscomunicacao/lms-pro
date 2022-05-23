<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;
use App\Models\Menu;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuJobsTest extends TestCase
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
    public function it_gets_menu_jobs()
    {
        $menu = Menu::factory()->create();
        $job = Job::factory()->create();

        $menu->jobs()->attach($job);

        $response = $this->getJson(route('api.menus.jobs.index', $menu));

        $response->assertOk()->assertSee($job->name);
    }

    /**
     * @test
     */
    public function it_can_attach_jobs_to_menu()
    {
        $menu = Menu::factory()->create();
        $job = Job::factory()->create();

        $response = $this->postJson(
            route('api.menus.jobs.store', [$menu, $job])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $menu
                ->jobs()
                ->where('jobs.id', $job->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_jobs_from_menu()
    {
        $menu = Menu::factory()->create();
        $job = Job::factory()->create();

        $response = $this->deleteJson(
            route('api.menus.jobs.store', [$menu, $job])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $menu
                ->jobs()
                ->where('jobs.id', $job->id)
                ->exists()
        );
    }
}
