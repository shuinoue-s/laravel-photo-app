<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $posts;
    private $tags;

    public function setUp() :void
    {
        parent::setUp();

        User::factory()->create();
        $this->user = User::first();

        Post::factory(3)->create([
            'user_id' => $this->user->id
        ]);
        $this->posts = Post::all();

        for ($i = 0; $i < 3; $i++) {
            $this->tags = Tag::create([
                'tag_name' => 'tag_test'. $i
            ]);
        }
        $this->tags = Tag::all();

        foreach ($this->posts as $post) {
            foreach ($this->tags as $tag) {
                $post->tags()->attach($tag->id);
            }
        }
    }

    /**
     * @test
     * @group tag_test
     */
    public function list_タグに紐づいた投稿一覧画面のURLにアクセスして表示される()
    {
       $response = $this->get(route('tag.list', ['id' => $this->tags[0]->id]));
       $response->assertViewIs('tag.list');
    }

    /**
     * @test
     * @group tag_test
     */
    public function list_タグに紐づいた投稿一覧画面のURLにアクセスしてタグの名前が表示される()
    {
       foreach ($this->tags as $tag) {
           $response = $this->get(route('tag.list', ['id' => $tag->id]));

           $response->assertSee($tag->tag_name);
       }
    }

    /**
     * @test
     * @group tag_test
     */
    public function list_タグに紐づいた投稿一覧画面のURLにアクセスしてタグに紐づいた全ての投稿が表示される()
    {
       foreach ($this->tags as $i => $tag) {
           $response = $this->get(route('tag.list', ['id' => $tag->id]));

           foreach ($tag->posts as $post) {
               $response->assertSee($post->file_path);
           }
       }
    }

    /**
     * @test
     * @group tag_test
     */
    public function search_タグ検索画面のURLにアクセスして表示される()
    {
        $response = $this->get(route('tag.search'));

        $response->assertViewIs('tag.search');
    }

    /**
     * @test
     * @group tag_test
     */
    public function result_タグ検索結果画面のURLにアクセスしてタグの名前が表示される()
    {
        foreach ($this->tags as $tag) {
            $response = $this->get(route('tag.result', [
                'tag' => $tag->tag_name
            ]));

            $response->assertSee($tag->tag_name);
        }
    }

    /**
     * @test
     * @group tag_test
     */
    public function result_タグ検索結果画面のURLにアクセスしてタグに紐づいた全ての投稿が表示される()
    {
        foreach ($this->tags as $tag) {
            $response = $this->get(route('tag.result', [
                'tag' => $tag->tag_name
            ]));

            foreach ($tag->posts as $post) {
                $response->assertSee($post->file_path);
            }
        }
    }

    /**
     * @test
     * @group tag_test
     */
    public function result_入力されたタグが存在しない場合はメッセージが表示される()
    {
            $response = $this->get(route('tag.result', [
                'tag' => 'not exist'
            ]));

            $response->assertSee('検索結果はありません');
    }
}
