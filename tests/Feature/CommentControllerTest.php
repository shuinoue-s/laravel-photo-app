<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $post;

    public function setUp() :void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user = User::first();

        Post::factory()->create([
            'user_id' => $this->user->id
        ]);
        $this->post = Post::first();
    }

    /**
     * @test
     * @group comment_test
     */
    public function create_コメントを投稿し保存できる()
    {
        $this->actingAs($this->user);

        $response = $this->from(route('post.show', ['id' => $this->post->id]))
            ->post(route('comment.create', ['id' => $this->post->id]), [
                'comment' => 'test_comment'
            ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => 'test_comment'
        ]);

        $response->assertRedirect(route('post.show', ['id' => $this->post->id]));
    }

    /**
     * @test
     * @group comment_test
     */
    public function destroy_コメントを削除する()
    {
        $this->actingAs($this->user);

        Comment::create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => 'test_comment'
        ]);

        $response = $this->from(route('post.show', ['id' => $this->post->id]))
            ->delete(route('comment.destroy', ['id' => $this->post->id]));

        $this->assertEquals(0, Comment::count());

        $response->assertRedirect(route('post.show', ['id' => $this->post->id]));
    }
}
