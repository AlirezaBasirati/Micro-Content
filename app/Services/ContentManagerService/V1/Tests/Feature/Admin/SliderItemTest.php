<?php

namespace App\Services\ContentManagerService\V1\Tests\Feature\Admin;

use App\Services\ContentManagerService\V1\Models\SliderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SliderItemTest extends TestCase
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
        $data = SliderItem::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->postJson('/api/admin/v1/slider-items', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_update()
    {
        $data = SliderItem::factory()->create()->toArray();
        $id = $data['id'];

        $data = SliderItem::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->postJson('/api/admin/v1/slider-items/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'        => $id,
                    'title'     => $data['title'],
                    'url'       => $data['url'],
                    'status'    => $data['status'],
                    'slider_id' => $data['slider_id'],
                    'image_url' => $data['image_url'],
                ]
            ]);
    }

    public function test_list()
    {
        SliderItem::factory()->count(100)->create();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/slider-items');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll(
                        'id',
                        'title',
                        'url',
                        'status',
                        'slider_id',
                        'image_url',
                    )
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = SliderItem::factory()->create()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/slider-items/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'        => $data['id'],
                    'title'     => $data['title'],
                    'url'       => $data['url'],
                    'status'    => $data['status'],
                    'slider_id' => $data['slider_id'],
                    'image_url' => $data['image_url'],
                ]
            ]);
    }

    public function test_delete()
    {
        $data = SliderItem::factory()->create()->toArray();
        $id = $data['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->delete('/api/admin/v1/slider-items/' . $id);

        $response->assertOk();
    }

    /** @dataProvider invalidSliderItemCreateInformation */
    public function test_slider_item_create_validation(array $data, string $invalid)
    {
        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->post('/api/admin/v1/slider-items', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    /** @dataProvider invalidSliderItemUpdateInformation */
    public function test_slider_item_update_validation(array $data, string $invalid)
    {
        $seed = SliderItem::factory()->create()->toArray();
        $id = $seed['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->post('/api/admin/v1/slider-items/' . $id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    public static function invalidSliderItemCreateInformation(): array
    {
        return [
            'title.required' => [['title' => '', 'slider_id' => 1], 'title'],
            'title.string'   => [['title' => 12312, 'slider_id' => 1], 'title'],

            'slider_id.required' => [['slider_id' => '', 'title' => 'title'], 'slider_id'],
            'slider_id.integer'  => [['slider_id' => 'slider id', 'title' => 'title'], 'slider_id'],

            'status.boolean' => [['status' => 'not-bool', 'title' => 'title', 'slider_id' => 1], 'status'],

            'image.file' => [['image' => 'not-bool', 'title' => 'title', 'slider_id' => 1], 'image'],

            'url.string' => [['url' => 12324, 'title' => 'title', 'slider_id' => 1], 'url'],
        ];
    }

    public static function invalidSliderItemUpdateInformation(): array
    {
        return [
            'title.string' => [['title' => '12312'], 'title'],

            'slider_id.integer' => [['slider_id' => 'slider id'], 'slider_id'],

            'status.boolean' => [['status' => 'not-bool'], 'status'],

            'image.file' => [['image' => 'not-bool'], 'image'],

            'url.string' => [['url' => 134], 'url'],
        ];
    }
}
