<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\UploadedFile;




class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
        User::factory()->create();
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で画像と本文を入力し登録できる()
    {

        $user = User::findOrFail(1);
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('test.png');
        $response = $this->post(route('mypage.create'), [
            'image' => $file,
            'body' => 'test',
            'name' => $user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => 'test'
        ]);

        $response->assertStatus(302);
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で画像のみを入力し登録できる()
    {
        $user = User::findOrFail(2);
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('test.png');
        $respose = $this->post(route('mypage.create'), [
            'image' => $file,
            'name' => $user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => ''
        ]);

        $respose->assertStatus(302);
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で本文のみを入力し登録できる()
    {
        $user = User::findOrFail(3);
        $this->actingAs($user);
        $respose = $this->post(route('mypage.create'), [
            'body' => 'test',
            'name' => $user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => '',
            'profile_body' => 'test'
        ]);

        $respose->assertStatus(302);
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で何も入力しない場合リダイレクト()
    {
        $user = User::findOrFail(4);
        $this->actingAs($user);
        $respose = $this->post(route('mypage.create'), [
            'name' => $user->name
        ]);

        $respose->assertStatus(302);
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で画像と本文を入力し更新できる()
    {
        $user = User::findOrFail(5);
        $this->actingAs($user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->post(route('mypage.create'), [
            'image' => $file,
            'body' => 'test',
            'name' => $user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => 'test'
        ]);

        $response->assertStatus(302);
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で画像のみを入力し更新できる()
    {
        $user = User::findOrFail(6);
        $this->actingAs($user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->post(route('mypage.create'), [
            'image' => $file,
            'name' => $user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => ''
        ]);

        $response->assertStatus(302);
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で本文のみを入力し更新できる()
    {
        $user = User::findOrFail(7);
        $this->actingAs($user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->post(route('mypage.create'), [
            'body' => 'test',
            'name' => $user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => $default_file,
            'profile_body' => 'test'
        ]);

        $response->assertStatus(302);
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で何も入力しない場合リダイレクト()
    {
        $user = User::findOrFail(8);
        $this->actingAs($user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        Profile::create([
            'user_id' => $user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->post(route('mypage.create'), [
            'name' => $user->name
        ]);

        $response->assertStatus(302);
    }

}
