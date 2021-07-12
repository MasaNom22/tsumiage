<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAvatarUpload()
    {
        $user = factory(User::class)->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $path = route('users.update', ['user' => $user]);

        $response = $this->actingAs($user)->json('PATCH', $path, [
            'avatar' => $file,
        ]);
        $response->assertSessionHasNoErrors();        
    }

    public function testGuestShow()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('users.show', ['user' => $user]));

        $response->assertRedirect(route('login'));
    }

    public function testAuthShow()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
        ->get(route('users.show', ['user' => $user]));

        $response->assertStatus(200)->assertViewIs('users.show')
        ->assertSee('投稿数');
    }

    public function testGuestEdit()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('users.edit', ['user' => $user]));

        $response->assertRedirect(route('login'));
    }

    public function testAuthEdit()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
        ->get(route('users.edit', ['user' => $user]));

        $response->assertStatus(200)->assertViewIs('users.edit')
        ->assertSee('プロフィール編集');
    }

    //他人のプロフィールは変更出来ない
    public function testAuthPolicyEdit()
    {
        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $response = $this->actingAs($user)
        ->get(route('users.edit', ['user' => $user1]));

        $response->assertStatus(403);
    }

    public function testGuestUpdate()
    {
        $user = factory(User::class)->create();
        $user_name = 'テスト太郎';
        $self_introduction = 'よろしくお願いします';
        
        $response = $this->patch(route('users.update', ['user' => $user]), [
            'name' => $user_name,
            'email' => 'test@example.com',
            'self_introduction' => $user_name,
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => $user_name,
            'email' => 'test@example.com',
            'self_introduction' => $user_name,
        ]);

    }

    public function testAuthUpdate()
    {
        $user = factory(User::class)->create();
        $user_name = 'テスト太郎';
        $self_introduction = 'よろしくお願いします';
        
        $response = $this->actingAs($user)->patch(route('users.update', ['user' => $user]), [
            'name' => $user_name,
            'email' => 'test@example.com',
            'self_introduction' => $user_name,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user_name,
            'email' => 'test@example.com',
            'self_introduction' => $user_name,
        ]);
        $response->assertStatus(302);

    }
}
