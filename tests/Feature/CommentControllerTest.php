<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_comments()
    {
        $comments = Comment::factory()->count(20)->create();
        $response = $this->get('/api/comments');

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'comments');
        $response->assertJson([
            'message' => 'success',
            'hasMore' => true,
        ]);
    }

    /** @test */
    public function it_returns_comments_with_search_keyword()
    {
        $comments = Comment::factory()->count(20)->create();
        $response = $this->get('/api/comments/search?keywords=test');

        $response->assertStatus(200);
        $response->assertJson([
            'hasMore' => false,
        ]);
    }
}
