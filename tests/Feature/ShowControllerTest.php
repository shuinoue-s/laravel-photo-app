<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $post;
    private $tag;

    public function setUp() :void
    {
        parent::setUp();

        User::factory()->create();
        $this->user = User::first();

        $this->post = Post::factory()->create([
            'user_id' => $this->user->id
        ]);
        $this->post = Post::first();

        $this->tag = Tag::create([
            'tag_name' => 'test_tag'
        ]);

        $this->post->tags()->attach($this->tag->id);
    }

    /**
     * @test
     * @group show_test
     */
    public function index_投稿一覧画面のURLにアクセスして投稿一覧画面が表示される()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('index'));
        $response->assertViewIs('index');
    }

    /**
     * @test
     * @group show_test
     */
    public function show_投稿詳細画面のURLにアクセスして投稿詳細画面が表示される()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('post.show', ['id' => $this->post->id]));
        $response->assertViewIs('post.show');
    }

    /**
     * @test
     * @group show_test
     */
    public function show_投稿詳細画面のURLにアクセスして投稿の詳細が表示される()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('post.show', ['id' => $this->post->id]));
        $response->assertSee($this->user->name);
        $response->assertSee($this->post->file_path);
        $response->assertSee($this->post->title);
        $response->assertSee($this->post->dscroption);
        $response->assertSee($this->tag->tag_name);
    }

    /**
     * @test
     * @group show_test
     */
    public function show_投稿詳細画面のURLにアクセスしてコメントが表示される()
    {
        $this->actingAs($this->user);

        Comment::create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => 'test_comment'
        ]);

        $response = $this->get(route('post.show', ['id' => $this->post->id]));
        $response->assertSee('test_comment');
        $response->assertSee($this->user->name);
    }

    /**
     * @test
     * @group show_test
     */
    public function destroy_投稿を削除できる()
    {
        $this->actingAs($this->user);

        $response = $this->from(route('post.show', ['id' => $this->post->id]))
            ->delete(route('post.destroy', ['id' => $this->post->id]));

        $this->assertEquals(0, Post::count());

        $response->assertRedirect(route('post.list'));
    }
}
