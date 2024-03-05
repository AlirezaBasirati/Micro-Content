<?php

namespace App\Services\ContentManagerService\V1\Tests\Feature\Admin;

use App\Services\ContentManagerService\V1\Models\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SliderTest extends TestCase
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
        $data = Slider::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->postJson('/api/admin/v1/sliders', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_update()
    {
        $data = Slider::factory()->create()->toArray();
        $id = $data['id'];

        $data = Slider::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patchJson('/api/admin/v1/sliders/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'          => $id,
                    'title'       => $data['title'],
                    'position_id' => $data['position_id'],
                    'type'        => $data['type'],
                    'status'      => $data['status'],
                    'height'      => $data['height'],
                    'width'       => $data['width'],
                ]
            ]);
    }

    public function test_list()
    {
        Slider::factory()->count(100)->create();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/sliders');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll(
                        'id',
                        'title',
                        'type',
                        'position_id',
                        'status',
                        'height',
                        'width')
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = Slider::factory()->create()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/sliders/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'          => $data['id'],
                    'title'       => $data['title'],
                    'position_id' => $data['position_id'],
                    'type'        => $data['type'],
                    'status'      => $data['status'],
                    'height'      => $data['height'],
                    'width'       => $data['width'],
                ]
            ]);
    }

    public function test_delete()
    {
        $data = Slider::factory()->create()->toArray();
        $id = $data['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->delete('/api/admin/v1/sliders/' . $id);

        $response->assertOk();
    }

    /** @dataProvider invalidSliderCreateInformation */
    public function test_slider_create_validation(array $data, string $invalid)
    {
        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->post('/api/admin/v1/sliders', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    /** @dataProvider invalidSliderUpdateInformation */
    public function test_slider_update_validation(array $data, string $invalid)
    {
        $seed = Slider::factory()->create()->toArray();
        $id = $seed['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patch('/api/admin/v1/sliders/' . $id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    public static function invalidSliderCreateInformation(): array
    {
        return [
            'title.required' => [['title' => '', 'type' => 'type', 'position_id' => 1], 'title'],
            'title.string'   => [['title' => 12312, 'type' => 'type', 'position_id' => 1], 'title'],

            'type.required' => [['type' => '', 'title' => 'title', 'position_id' => 1], 'type'],
            'type.string'   => [['type' => 64516516, 'title' => 'title', 'position_id' => 1], 'type'],

            'position_id.required' => [['position_id' => '', 'title' => 'title', 'type' => 'type'], 'position_id'],
            'position_id.integer'  => [['position_id' => 'position', 'title' => 'title', 'type' => 'type'], 'position_id'],

            'status.boolean' => [['status' => 'not-bool', 'title' => 'title', 'type' => 'type', 'position_id' => 1], 'status'],

            'height.boolean' => [['height' => 'not-bool', 'title' => 'title', 'type' => 'type', 'position_id' => 1], 'height'],

            'width.boolean' => [['width' => 'not-bool', 'title' => 'title', 'type' => 'type', 'position_id' => 1], 'width'],
        ];
    }

    public static function invalidSliderUpdateInformation(): array
    {
        return [
            'title.string' => [['title' => 12312], 'title'],

            'type.string' => [['type' => 64516516], 'type'],

            'position_id.integer' => [['position_id' => 'position'], 'position_id'],

            'status.boolean' => [['status' => 'not-bool'], 'status'],

            'height.boolean' => [['height' => 'not-bool'], 'height'],

            'width.boolean' => [['width' => 'not-bool'], 'width'],
        ];
    }
}
