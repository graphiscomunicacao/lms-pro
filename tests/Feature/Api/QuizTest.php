<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quiz;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizTest extends TestCase
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
    public function it_gets_quizzes_list()
    {
        $quizzes = Quiz::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.quizzes.index'));

        $response->assertOk()->assertSee($quizzes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_quiz()
    {
        $data = Quiz::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.quizzes.store'), $data);

        unset($data['experience_amount']);

        $this->assertDatabaseHas('quizzes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.quizzes.update', $quiz), $data);

        unset($data['experience_amount']);

        $data['id'] = $quiz->id;

        $this->assertDatabaseHas('quizzes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_quiz()
    {
        $quiz = Quiz::factory()->create();

        $response = $this->deleteJson(route('api.quizzes.destroy', $quiz));

        $this->assertSoftDeleted($quiz);

        $response->assertNoContent();
    }
}
