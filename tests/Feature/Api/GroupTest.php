<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Group;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
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
    public function it_gets_groups_list()
    {
        $groups = Group::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.groups.index'));

        $response->assertOk()->assertSee($groups[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_group()
    {
        $data = Group::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.groups.store'), $data);

        $this->assertDatabaseHas('groups', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.groups.update', $group), $data);

        $data['id'] = $group->id;

        $this->assertDatabaseHas('groups', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_group()
    {
        $group = Group::factory()->create();

        $response = $this->deleteJson(route('api.groups.destroy', $group));

        $this->assertModelMissing($group);

        $response->assertNoContent();
    }
}
