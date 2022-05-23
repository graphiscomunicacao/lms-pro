<?php

namespace Tests\Feature\Api;

use App\Models\Job;
use App\Models\User;
use App\Models\Menu;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobMenusTest extends TestCase
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
    public function it_gets_job_menus()
    {
        $job = Job::factory()->create();
        $menu = Menu::factory()->create();

        $job->menus()->attach($menu);

        $response = $this->getJson(route('api.jobs.menus.index', $job));

        $response->assertOk()->assertSee($menu->name);
    }

    /**
     * @test
     */
    public function it_can_attach_menus_to_job()
    {
        $job = Job::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->postJson(
            route('api.jobs.menus.store', [$job, $menu])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $job
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_menus_from_job()
    {
        $job = Job::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->deleteJson(
            route('api.jobs.menus.store', [$job, $menu])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $job
                ->menus()
                ->where('menus.id', $menu->id)
                ->exists()
        );
    }
}
