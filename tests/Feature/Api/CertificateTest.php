<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Certificate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CertificateTest extends TestCase
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
    public function it_gets_certificates_list()
    {
        $certificates = Certificate::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.certificates.index'));

        $response->assertOk()->assertSee($certificates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_certificate()
    {
        $data = Certificate::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.certificates.store'), $data);

        $this->assertDatabaseHas('certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_certificate()
    {
        $certificate = Certificate::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'background_path' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.certificates.update', $certificate),
            $data
        );

        $data['id'] = $certificate->id;

        $this->assertDatabaseHas('certificates', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_certificate()
    {
        $certificate = Certificate::factory()->create();

        $response = $this->deleteJson(
            route('api.certificates.destroy', $certificate)
        );

        $this->assertModelMissing($certificate);

        $response->assertNoContent();
    }
}
