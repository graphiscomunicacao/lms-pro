<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\LearningPath;

use App\Models\Certificate;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LearningPathControllerTest extends TestCase
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
    public function it_displays_index_view_with_learning_paths()
    {
        $learningPaths = LearningPath::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('learning-paths.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.learning_paths.index')
            ->assertViewHas('learningPaths');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_learning_path()
    {
        $response = $this->get(route('learning-paths.create'));

        $response->assertOk()->assertViewIs('app.learning_paths.create');
    }

    /**
     * @test
     */
    public function it_stores_the_learning_path()
    {
        $data = LearningPath::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('learning-paths.store'), $data);

        unset($data['experience_amount']);

        $this->assertDatabaseHas('learning_paths', $data);

        $learningPath = LearningPath::latest('id')->first();

        $response->assertRedirect(route('learning-paths.edit', $learningPath));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_learning_path()
    {
        $learningPath = LearningPath::factory()->create();

        $response = $this->get(route('learning-paths.show', $learningPath));

        $response
            ->assertOk()
            ->assertViewIs('app.learning_paths.show')
            ->assertViewHas('learningPath');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_learning_path()
    {
        $learningPath = LearningPath::factory()->create();

        $response = $this->get(route('learning-paths.edit', $learningPath));

        $response
            ->assertOk()
            ->assertViewIs('app.learning_paths.edit')
            ->assertViewHas('learningPath');
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

        $response = $this->put(
            route('learning-paths.update', $learningPath),
            $data
        );

        unset($data['experience_amount']);

        $data['id'] = $learningPath->id;

        $this->assertDatabaseHas('learning_paths', $data);

        $response->assertRedirect(route('learning-paths.edit', $learningPath));
    }

    /**
     * @test
     */
    public function it_deletes_the_learning_path()
    {
        $learningPath = LearningPath::factory()->create();

        $response = $this->delete(
            route('learning-paths.destroy', $learningPath)
        );

        $response->assertRedirect(route('learning-paths.index'));

        $this->assertModelMissing($learningPath);
    }
}
