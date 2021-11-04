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

    private $user;

    public function setUp() :void
    {
        parent::setUp();

        User::factory()->create();
        $this->user = User::first();
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成でユーザー名を変更かつ画像と本文を入力し登録できる()
    {

        $this->actingAs($this->user);
        $file = UploadedFile::fake()->image('test.png');
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'body' => 'test',
            'name' => 'test_name'
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => 'test'
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test_name'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成でユーザー名を変更かつ画像のみを入力し登録できる()
    {

        $this->actingAs($this->user);
        $file = UploadedFile::fake()->image('test.png');
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'name' => 'test_name'
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test_name'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成でユーザー名を変更かつ本文のみを入力し登録できる()
    {

        $this->actingAs($this->user);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'body' => 'test',
            'name' => 'test_name'
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_body' => 'test'
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test_name'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で画像と本文を入力し登録できる()
    {

        $this->actingAs($this->user);
        $file = UploadedFile::fake()->image('test.png');
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'body' => 'test',
            'name' => $this->user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => 'test'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で画像のみを入力し登録できる()
    {
        $this->actingAs($this->user);
        $file = UploadedFile::fake()->image('test.png');
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'name' => $this->user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => ''
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で本文のみを入力し登録できる()
    {
        $this->actingAs($this->user);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'body' => 'test',
            'name' => $this->user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => '',
            'profile_body' => 'test'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール未作成で何も入力しない場合リダイレクト()
    {
        $this->actingAs($this->user);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'name' => $this->user->name
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済でユーザー名を変更かつ画像と本文を入力し更新できる()
    {
        $this->actingAs($this->user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $this->user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'body' => 'test',
            'name' => 'test_name'
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => 'test'
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test_name'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済でユーザー名を変更かつ画像のみを入力し更新できる()
    {
        $this->actingAs($this->user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $this->user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'name' => 'test_name'
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName()
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test_name'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済でユーザー名を変更かつ本文のみを入力し更新できる()
    {;
        $this->actingAs($this->user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        Profile::create([
            'user_id' => $this->user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'body' => 'test',
            'name' => 'test_name'
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_body' => 'test'
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test_name'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で画像と本文を入力し更新できる()
    {;
        $this->actingAs($this->user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $this->user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'body' => 'test',
            'name' => $this->user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => 'test'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で画像のみを入力し更新できる()
    {;
        $this->actingAs($this->user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $this->user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'image' => $file,
            'name' => $this->user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => 'uploads/' . $file->hashName(),
            'profile_body' => ''
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で本文のみを入力し更新できる()
    {;
        $this->actingAs($this->user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        $file = UploadedFile::fake()->image('test.png');
        Profile::create([
            'user_id' => $this->user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'body' => 'test',
            'name' => $this->user->name
        ]);

        $this->assertDatabaseHas('profiles', [
            'profile_image' => $default_file,
            'profile_body' => 'test'
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function create_プロフィール作成済で何も入力しない場合リダイレクト()
    {;
        $this->actingAs($this->user);
        $default_file = UploadedFile::fake()->image('default.png')->hashName();
        Profile::create([
            'user_id' => $this->user->id,
            'profile_image' => $default_file,
            'profile_body' => 'default_test'
        ]);
        $response = $this->from(route('mypage.edit'))->post(route('mypage.create'), [
            'name' => $this->user->name
        ]);

        $response->assertRedirect(route('mypage.profile'));
    }

    /**
     * @test
     * @group profile_test
     */
    public function destroy_アカウントを削除できる()
    {
        $this->actingAs($this->user);

        $response = $this->from(route('mypage.profile'))
            ->delete(route('mypage.destroy', ['id' => $this->user->id]));

        $this->assertEquals(0, User::count());
        $response->assertRedirect(route('mypage.profile'));
    }
}
