<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Certificate;
use App\Models\LearningPath;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CertificateLearningPathsTest extends TestCase
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
    public function it_gets_certificate_learning_paths()
    {
        $certificate = Certificate::factory()->create();
        $learningPaths = LearningPath::factory()
            ->count(2)
            ->create([
                'certificate_id' => $certificate->id,
            ]);

        $response = $this->getJson(
            route('api.certificates.learning-paths.index', $certificate)
        );

        $response->assertOk()->assertSee($learningPaths[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_certificate_learning_paths()
    {
        $certificate = Certificate::factory()->create();
        $data = LearningPath::factory()
            ->make([
                'certificate_id' => $certificate->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.certificates.learning-paths.store', $certificate),
            $data
        );

        unset($data['experience_amount']);

        $this->assertDatabaseHas('learning_paths', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $learningPath = LearningPath::latest('id')->first();

        $this->assertEquals($certificate->id, $learningPath->certificate_id);
    }
}
