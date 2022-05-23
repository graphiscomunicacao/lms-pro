<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Group;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupControllerTest extends TestCase
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
    public function it_displays_index_view_with_groups()
    {
        $groups = Group::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('groups.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.groups.index')
            ->assertViewHas('groups');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_group()
    {
        $response = $this->get(route('groups.create'));

        $response->assertOk()->assertViewIs('app.groups.create');
    }

    /**
     * @test
     */
    public function it_stores_the_group()
    {
        $data = Group::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('groups.store'), $data);

        $this->assertDatabaseHas('groups', $data);

        $group = Group::latest('id')->first();

        $response->assertRedirect(route('groups.edit', $group));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_group()
    {
        $group = Group::factory()->create();

        $response = $this->get(route('groups.show', $group));

        $response
            ->assertOk()
            ->assertViewIs('app.groups.show')
            ->assertViewHas('group');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_group()
    {
        $group = Group::factory()->create();

        $response = $this->get(route('groups.edit', $group));

        $response
            ->assertOk()
            ->assertViewIs('app.groups.edit')
            ->assertViewHas('group');
    }

    /**
     * @test
     */
    public function it_updates_the_group()
    {
        $group = Group::factory()->create();

        $data = [
            'name' => $this->faker->word,
        ];

        $response = $this->put(route('groups.update', $group), $data);

        $data['id'] = $group->id;

        $this->assertDatabaseHas('groups', $data);

        $response->assertRedirect(route('groups.edit', $group));
    }

    /**
     * @test
     */
    public function it_deletes_the_group()
    {
        $group = Group::factory()->create();

        $response = $this->delete(route('groups.destroy', $group));

        $response->assertRedirect(route('groups.index'));

        $this->assertModelMissing($group);
    }
}
