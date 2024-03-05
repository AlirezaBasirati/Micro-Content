<?php

namespace App\Services\ContentManagerService\V1\Tests\Feature\Admin;

use App\Services\ContentManagerService\V1\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create(): void
    {
        $data = Faq::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->postJson('/api/admin/v1/faqs', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_update()
    {
        $data = Faq::factory()->create()->toArray();
        $id = $data['id'];

        $data = Faq::factory()->make()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patchJson('/api/admin/v1/faqs/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'       => $id,
                    'question' => $data['question'],
                    'answer'   => $data['answer'],
                    'status'   => $data['status'],
                ]
            ]);
    }

    public function test_list()
    {
        Faq::factory()->count(100)->create();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/faqs');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll(
                        'id',
                        'question',
                        'answer',
                        'status',
                    )
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = Faq::factory()->create()->toArray();

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->getJson('/api/admin/v1/faqs/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'       => $data['id'],
                    'question' => $data['question'],
                    'answer'   => $data['answer'],
                    'status'   => $data['status'],
                ]
            ]);
    }

    public function test_delete()
    {
        $data = Faq::factory()->create()->toArray();
        $id = $data['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->delete('/api/admin/v1/faqs/' . $id);

        $response->assertOk();
    }

    /** @dataProvider invalidFaqCreateInformation */
    public function test_faq_create_validation(array $data, string $invalid)
    {
        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->post('/api/admin/v1/faqs', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    /** @dataProvider invalidFaqUpdateInformation */
    public function test_faq_update_validation(array $data, string $invalid)
    {
        $seed = Faq::factory()->create()->toArray();
        $id = $seed['id'];

        $response = $this
            ->withHeaders([config('authenticate.user_id') => 1])
            ->patch('/api/admin/v1/faqs/' . $id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');

    }

    public static function invalidFaqCreateInformation(): array
    {
        return [
            'question.required' => [['question' => '', 'answer' => 'this is answer'], 'question'],
            'question.string'   => [['question' => 12312, 'answer' => 'this is answer'], 'question'],

            'answer.required' => [['answer' => '', 'question' => 'this is question?'], 'answer'],
            'answer.string'   => [['answer' => 64516516, 'question' => 'this is question?'], 'answer'],

            'status.boolean' => [['status' => 'not-bool', 'question' => 'this is question?', 'answer' => 'this is answer'], 'status'],
        ];
    }

    public static function invalidFaqUpdateInformation(): array
    {
        return [
            'question.string' => [['question' => 12312], 'question'],

            'answer.string' => [['answer' => 64516516], 'answer'],

            'status.boolean' => [['status' => 'not-bool'], 'status'],
        ];
    }
}
