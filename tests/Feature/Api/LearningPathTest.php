<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LearningPath;

use App\Models\Certificate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathTest extends TestCase
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
    public function it_gets_learning_paths_list()
    {
        $learningPaths = LearningPath::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.learning-paths.index'));

        $response->assertOk()->assertSee($learningPaths[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_learning_path()
    {
        $data = LearningPath::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.learning-paths.store'), $data);

        unset($data['experience_amount']);

        $this->assertDatabaseHas('learning_paths', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_learning_path()
    {
        $learningPath = LearningPath::factory()->create();

        $certificate = Certificate::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'cover_path' => $this->faker->text(255),
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
            'availability_time' => $this->faker->randomNumber(0),
            'tries' => $this->faker->randomNumber(0),
            'passing_score' => $this->faker->randomNumber(0),
            'approval_goal' => $this->faker->randomNumber(0),
            'experience_amount' => $this->faker->randomNumber(0),
            'certificate_id' => $certificate->id,
        ];

        $response = $this->putJson(
            route('api.learning-paths.update', $learningPath),
            $data
        );

        unset($data['experience_amount']);

        $data['id'] = $learningPath->id;

        $this->assertDatabaseHas('learning_paths', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_learning_path()
    {
        $learningPath = LearningPath::factory()->create();

        $response = $this->deleteJson(
            route('api.learning-paths.destroy', $learningPath)
        );

        $this->assertModelMissing($learningPath);

        $response->assertNoContent();
    }
}
