<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Quiz;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizControllerTest extends TestCase
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
    public function it_displays_index_view_with_quizzes()
    {
        $quizzes = Quiz::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('quizzes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.quizzes.index')
            ->assertViewHas('quizzes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_quiz()
    {
        $response = $this->get(route('quizzes.create'));

        $response->assertOk()->assertViewIs('app.quizzes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_quiz()
    {
        $data = Quiz::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('quizzes.store'), $data);

        unset($data['experience_amount']);

        $this->assertDatabaseHas('quizzes', $data);

        $quiz = Quiz::latest('id')->first();

        $response->assertRedirect(route('quizzes.edit', $quiz));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_quiz()
    {
        $quiz = Quiz::factory()->create();

        $response = $this->get(route('quizzes.show', $quiz));

        $response
            ->assertOk()
            ->assertViewIs('app.quizzes.show')
            ->assertViewHas('quiz');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_quiz()
    {
        $quiz = Quiz::factory()->create();

        $response = $this->get(route('quizzes.edit', $quiz));

        $response
            ->assertOk()
            ->assertViewIs('app.quizzes.edit')
            ->assertViewHas('quiz');
    }

    /**
     * @test
     */
    public function it_updates_the_quiz()
    {
        $quiz = Quiz::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence(15),
            'time_limit' => $this->faker->time,
            'cover_path' => $this->faker->text(255),
            'experience_amount' => $this->faker->randomNumber(0),
        ];

        $response = $this->put(route('quizzes.update', $quiz), $data);

        unset($data['experience_amount']);

        $data['id'] = $quiz->id;

        $this->assertDatabaseHas('quizzes', $data);

        $response->assertRedirect(route('quizzes.edit', $quiz));
    }

    /**
     * @test
     */
    public function it_deletes_the_quiz()
    {
        $quiz = Quiz::factory()->create();

        $response = $this->delete(route('quizzes.destroy', $quiz));

        $response->assertRedirect(route('quizzes.index'));

        $this->assertSoftDeleted($quiz);
    }
}
