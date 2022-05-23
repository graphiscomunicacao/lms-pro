<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningArtifact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningArtifactTest extends TestCase
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
    public function it_gets_learning_artifacts_list()
    {
        $learningArtifacts = LearningArtifact::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.learning-artifacts.index'));

        $response->assertOk()->assertSee($learningArtifacts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_learning_artifact()
    {
        $data = LearningArtifact::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.learning-artifacts.store'),
            $data
        );

        unset($data['experience_amount']);

        $this->assertDatabaseHas('learning_artifacts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.learning-artifacts.update', $learningArtifact),
            $data
        );

        unset($data['experience_amount']);

        $data['id'] = $learningArtifact->id;

        $this->assertDatabaseHas('learning_artifacts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_learning_artifact()
    {
        $learningArtifact = LearningArtifact::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-artifacts.destroy', $learningArtifact)
        );

        $this->assertSoftDeleted($learningArtifact);

        $response->assertNoContent();
    }
}
