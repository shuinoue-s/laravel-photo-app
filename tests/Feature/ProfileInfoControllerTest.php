<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileInfoControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $post;
    private $profile;

    public function setUp() :void
    {
        parent::setUp();

        User::factory()->create();
        $this->user = User::first();

        Post::factory()->create([
            'user_id' => $this->user->id
        ]);
        $this->post = Post::first();

        Profile::factory()->create([
            'user_id' => $this->user->id
        ]);
        $this->profile = Profile::first();
    }

    /**
     * @test
     * @group profile_info_test
     */
    public function profileInfo_プロフィール詳細ページのURLにアクセスしてプロフィール詳細画面が表示される()
    {
        $this->actingAs($this->user);

        $response = $this->from(route('post.show',['id' => $this->user->id]))
            ->get(route('mypage.profile_info', ['name' => $this->user->name]));

        $response->assertViewIs('mypage.profile_info');
    }

    /**
     * @test
     * @group profile_info_test
     */
    public function profileInfo_プロフィール詳細ページのURLにアクセスしてプロフィール情報が表示される()
    {
        $this->actingAs($this->user);

        $response = $this->from(route('post.show',['id' => $this->user->id]))
            ->get(route('mypage.profile_info', ['name' => $this->user->name]));

        $response->assertSee($this->user->name);
        $response->assertSee($this->profile->profile_image);
        $response->assertSee($this->profile->profile_body);
    }

    /**
     * @test
     * @group profile_info_test
     */
    public function profileInfo_プロフィール詳細ページのURLにアクセスしてユーザーの投稿一覧が表示される()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.png');
        $post = [];

        for ($i = 0; $i < 3; $i++) {
            $post[$i] = Post::factory()->create([
                'user_id' => $this->user->id,
                'file_path' => 'uploads/' . $file->hashName(),
            ]);
        }

        $response = $this->from(route('post.show',['id' => $this->user->id]))
            ->get(route('mypage.profile_info', ['name' => $this->user->name]));

        for ($i = 0; $i < 3; $i++) {
            $response->assertSee($post[$i]->file_path);
        }
    }
}
