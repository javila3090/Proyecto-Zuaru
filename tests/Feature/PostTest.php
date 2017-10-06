<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testsPostsAreCreatedCorrectly()
    {
        $payload = [
            'user_id' => 1,
            'title' => 'Lorem',
            'content' => 'Ipsum',
        ];

        $this->json('POST', '/api/post', $payload)
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
