<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningArtifactControllerTest extends TestCase
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
    public function it_displays_index_view_with_learning_artifacts()
    {
        $learningArtifacts = LearningArtifact::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('learning-artifacts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.learning_artifacts.index')
            ->assertViewHas('learningArtifacts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_learning_artifact()
    {
        $response = $this->get(route('learning-artifacts.create'));

        $response->assertOk()->assertViewIs('app.learning_artifacts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_learning_artifact()
    {
        $data = LearningArtifact::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('learning-artifacts.store'), $data);

        unset($data['experience_amount']);

        $this->assertDatabaseHas('learning_artifacts', $data);

        $learningArtifact = LearningArtifact::latest('id')->first();

        $response->assertRedirect(
            route('learning-artifacts.edit', $learningArtifact)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->get(
            route('learning-artifacts.show', $learningArtifact)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.learning_artifacts.show')
            ->assertViewHas('learningArtifact');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->get(
            route('learning-artifacts.edit', $learningArtifact)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.learning_artifacts.edit')
            ->assertViewHas('learningArtifact');
    }

    /**
     * @test
     */
    public function it_updates_the_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'type' => 'audio',
            'size' => $this->faker->randomFloat(2, 0, 9999),
            'path' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'external' => $this->faker->boolean,
            'url' => $this->faker->url,
            'cover_path' => $this->faker->text(255),
            'experience_amount' => $this->faker->randomNumber(0),
        ];

        $response = $this->put(
            route('learning-artifacts.update', $learningArtifact),
            $data
        );

        unset($data['experience_amount']);

        $data['id'] = $learningArtifact->id;

        $this->assertDatabaseHas('learning_artifacts', $data);

        $response->assertRedirect(
            route('learning-artifacts.edit', $learningArtifact)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->delete(
            route('learning-artifacts.destroy', $learningArtifact)
        );

        $response->assertRedirect(route('learning-artifacts.index'));

        $this->assertSoftDeleted($learningArtifact);
    }
}
