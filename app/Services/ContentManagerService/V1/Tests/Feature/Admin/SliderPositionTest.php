<?php

namespace App\Services\ContentManagerService\V1\Tests\Feature\Admin;

use App\Services\ContentManagerService\V1\Models\SliderPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SliderPositionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create(): void
    {
        $data = SliderPosition::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->postJson('/api/admin/v1/slider-positions', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_update()
    {
        $data = SliderPosition::factory()->create()->toArray();
        $id = $data['id'];

        $data = SliderPosition::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patchJson('/api/admin/v1/slider-positions/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'    => $id,
                    'title' => $data['title'],
                    'slug'  => $data['slug'],
                ]
            ]);
    }

    public function test_list()
    {
        SliderPosition::factory()->count(100)->create();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/slider-positions');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll(
                        'id',
                        'title',
                        'slug',
                    )
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = SliderPosition::factory()->create()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/slider-positions/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'    => $data['id'],
                    'title' => $data['title'],
                    'slug'  => $data['slug'],
                ]
            ]);
    }

    public function test_delete()
    {
        $data = SliderPosition::factory()->create()->toArray();
        $id = $data['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->delete('/api/admin/v1/slider-positions/' . $id);

        $response->assertOk();
    }

    /** @dataProvider invalidSliderPositionCreateInformation */
    public function test_slider_position_create_validation(array $data, string $invalid)
    {
        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->post('/api/admin/v1/slider-positions', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    /** @dataProvider invalidSliderPositionUpdateInformation */
    public function test_slider_position_update_validation(array $data, string $invalid)
    {
        $seed = SliderPosition::factory()->create()->toArray();
        $id = $seed['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patch('/api/admin/v1/slider-positions/' . $id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    public static function invalidSliderPositionCreateInformation(): array
    {
        return [
            'title.required' => [['title' => '', 'slug' => 'type'], 'title'],
            'title.string'   => [['title' => 12312, 'slug' => 'type'], 'title'],

            'slug.required' => [['slug' => '', 'title' => 'title'], 'slug'],
            'slug.string'   => [['slug' => 64516516, 'title' => 'title'], 'slug'],
        ];
    }

    public static function invalidSliderPositionUpdateInformation(): array
    {
        return [
            'title.string' => [['title' => 12312], 'title'],

            'slug.string' => [['slug' => 64516516], 'slug'],
        ];
    }
}
