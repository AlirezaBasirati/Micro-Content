<?php

namespace App\Services\ProductService\V1\Tests\Feature\Admin;

use App\Services\ProductService\V1\Models\Attribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create(): void
    {
        $data = Attribute::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->postJson('/api/admin/v1/attributes', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_update()
    {
        $data = Attribute::factory()->create()->toArray();
        $id = $data['id'];

        $data = Attribute::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patchJson('/api/admin/v1/attributes/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'                 => $id,
                    'title'              => $data['title'],
                    'slug'               => $data['slug'],
                    'type'               => $data['type'],
                    'searchable'         => $data['searchable'],
                    'filterable'         => $data['filterable'],
                    'comparable'         => $data['comparable'],
                    'visible'            => $data['visible'],
                    'attribute_group_id' => $data['attribute_group_id'],
                    'status'             => $data['status'],
                ]
            ]);
    }

    public function test_list()
    {
        Attribute::factory()->count(100)->create();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/attributes');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll(
                        'id',
                        'title',
                        'slug',
                        'type',
                        'searchable',
                        'filterable',
                        'attribute_group_id',
                        'comparable',
                        'visible',
                        'status',
                    )
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = Attribute::factory()->create()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/attributes/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'                 => $data['id'],
                    'title'              => $data['title'],
                    'slug'               => $data['slug'],
                    'type'               => $data['type'],
                    'searchable'         => $data['searchable'],
                    'filterable'         => $data['filterable'],
                    'comparable'         => $data['comparable'],
                    'attribute_group_id' => $data['attribute_group_id'],
                    'visible'            => $data['visible'],
                    'status'             => $data['status'],
                ]
            ]);
    }

    public function test_delete()
    {
        $data = Attribute::factory()->create()->toArray();
        $id = $data['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->delete('/api/admin/v1/attributes/' . $id);

        $response->assertOk();
    }

    /** @dataProvider invalidAttributeCreateInformation */
    public function test_attribute_create_validation(array $data, string $invalid)
    {
        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->post('/api/admin/v1/attributes', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    /** @dataProvider invalidAttributeUpdateInformation */
    public function test_attribute_update_validation(array $data, string $invalid)
    {
        $seed = Attribute::factory()->create()->toArray();
        $id = $seed['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patch('/api/admin/v1/attributes/' . $id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');

    }

    public static function invalidAttributeCreateInformation(): array
    {
        $data = ['title'              => 'title',
                 'slug'               => 'slug',
                 'type'               => 'simple',
                 'searchable'         => rand(0, 1),
                 'filterable'         => rand(0, 1),
                 'comparable'         => rand(0, 1),
                 'attribute_group_id' => rand(1, 10),
                 'visible'            => rand(0, 1),
                 'status'             => rand(0, 1),
        ];

        return [
            'title.required' => [Arr::set($data, 'title', ''), 'title'],
            'title.string'   => [Arr::set($data, 'title', 12312), 'title'],

            'slug.required' => [Arr::set($data, 'slug', ''), 'slug'],
            'slug.string'   => [Arr::set($data, 'slug', 65165), 'slug'],

            'type.required' => [Arr::set($data, 'type', ''), 'type'],
            'type.string'   => [Arr::set($data, 'type', 6565), 'type'],

            'attribute_group_id.integer' => [Arr::set($data, 'attribute_group_id', 'id'), 'attribute_group_id'],

            'status.integer' => [Arr::set($data, 'status', 'id'), 'status'],

            'searchable.integer' => [Arr::set($data, 'searchable', 'id'), 'searchable'],

            'filterable.integer' => [Arr::set($data, 'filterable', 'id'), 'filterable'],

            'comparable.integer' => [Arr::set($data, 'comparable', 'id'), 'comparable'],

            'visible.integer' => [Arr::set($data, 'visible', 'id'), 'visible'],
        ];
    }

    public static function invalidAttributeUpdateInformation(): array
    {
        return [
            'title.string' => [['title' => 12312], 'title'],

            'slug.string' => [['slug' => 6565], 'slug'],

            'type.string' => [['type' => 6565], 'type'],

            'attribute_group_id.integer' => [['attribute_group_id' => 'id'], 'attribute_group_id'],

            'status.integer' => [['status' => 'id'], 'status'],

            'searchable.integer' => [['searchable' => 'id'], 'searchable'],

            'filterable.integer' => [['filterable' => 'id'], 'filterable'],

            'comparable.integer' => [['comparable' => 'id'], 'comparable'],

            'visible.integer' => [['visible' => 'id'], 'visible'],
        ];
    }
}
