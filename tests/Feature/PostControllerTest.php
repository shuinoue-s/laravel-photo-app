<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp() :void
    {
        parent::setUp();

        User::factory()->create();
        $this->user = User::first();
    }

    /**
     * @test
     * @group post_test
     */
    public function form_投稿画面のURLにアクセスして表示される()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('post.form'));
        $response->assertViewIs('post.form');
    }

    /**
     * @test
     * @group post_test
     */
    public function form_ログインしていない場合は投稿画面のURLにアクセスしてもログイン画面へリダイレクトされる()
    {
        $response = $this->get(route('post.form'));
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     * @group post_test
     */
    public function upload_投稿を保存できる()
    {
        $this->actingAs($this->user);
        $file = UploadedFile::fake()->image('test.png');

        $response = $this->from(route('post.form'))->post(route('post.upload'), [
            'image' => $file,
            'title' => 'test_title',
            'description' => 'test_description',
            'tags' => '#test #テスト'
        ]);

        $this->assertDatabaseHas('posts', [
            'user_id' => $this->user->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => 'uploads/' . $file->hashName(),
            'title' => 'test_title',
            'description' => 'test_description'
        ]);

        $this->assertDatabaseHas('tags', [
            'tag_name' => ['test', 'テスト']
        ]);

        $response->assertRedirect(route('post.list'));
    }

    /**
     * @test
     * @group post_test
     */
    public function list_投稿一覧画面を表示する()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('post.list'));
        $response->assertViewIs('post.list');
    }

    /**
     * @test
     * @group post_test
     */
    public function list_ログインしていない場合は投稿一覧画面のURLにアクセスしてもログイン画面へリダイレクトされる()
    {
        $response = $this->get(route('post.list'));
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     * @group post_test
     */
    public function list_投稿一覧画面に全ての投稿が表示される()
    {
        $this->actingAs($this->user);
        $file = UploadedFile::fake()->image('test.png');
        $post = [];

        for ($i = 0; $i < 3; $i++) {
            $post[$i] = Post::factory()->create([
                'user_id' => $this->user->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => 'uploads/' . $file->hashName(),
                'title' => 'test_title' . $i
            ]);
        }

        $response = $this->get(route('post.list'));
        for ($i = 0; $i < 3; $i++) {
            $response->assertSee($post[$i]->file_path);
            $response->assertSee($this->user->name);
        }
    }
}
