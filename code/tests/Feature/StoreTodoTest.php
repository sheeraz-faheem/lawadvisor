<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTodoTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_todo()
    {
        $user = User::factory()->create();

        $data = [
            'title' => "test1234",
            'description' => 'hello',
        ];

        $response = $this->actingAs($user)->call('POST', '/api/todo', $data);
        $response->assertSuccessful();
    }
}