<?php

namespace Tests\Feature;

use App\User;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('posts.index'));

        $response->assertStatus(200)
            ->assertViewIs('posts.index')
            ->assertSee('積み上げアプリ');
    }

    public function testGuestCreate()
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }

    public function testAuthCreate()
    {
        //use App\User;が必要
        $user = factory(User::class)->create();
        //ログインしたユーザーでアクセス
        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertStatus(200)
            ->assertViewIs('posts.create')
            ->assertSee('投稿画面');
    }

    public function testGuestStore()
    {
        $response = $this->post(route('posts.store'));

        $response->assertRedirect(route('login'));
    }

    public function testAuthStore()
    {

        $post = factory(Post::class)->create();
        $user = $post->user;

        $response = $this->actingAs($user)->post(route('posts.store', [
            'title' => $post->title,
            'content' => $post->content,
            'study_hour' => $post->study_hour,
            'study_time' => $post->study_time,
            'study_date' => $post->study_date,
            'user_id' => $post->user_id,
        ]));

        $response->assertRedirect(route('posts.index'));
        //登録したデータが存在するかどうか
        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'content' => $post->content,
            'study_hour' => $post->study_hour,
            'study_time' => $post->study_time,
            'study_date' => $post->study_date,
            'user_id' => $post->user_id,
        ]);
    }

    public function testGuestEdit()
    {
        $post = factory(Post::class)->create();
        $user = $post->user;
        $response = $this->get(route('posts.edit', ['post' => $post]));

        $response->assertRedirect(route('login'));
    }

    public function testAuthEdit()
    {
        $post = factory(Post::class)->create();
        $user = $post->user;
        $response = $this->actingAs($user)
        ->get(route('posts.edit', ['post' => $post]));

        $response->assertStatus(200)->assertViewIs('posts.edit')
        ->assertSee($post->content);
    }

    public function testGuestUpdate()
    {
        $post = factory(Post::class)->create();
        $user = $post->user;
        $response = $this->post(route('posts.update', ['post' => $post]));

        $response->assertRedirect(route('login'));
    }

    public function testAuthUpdate()
    {
        $post = factory(Post::class)->create();
        $user = $post->user;
        $post1 = factory(Post::class)->create();

        $response = $this->actingAs($user)->post(route('posts.store', [
            'title' => $post->title,
            'content' => $post->content,
            'study_hour' => $post->study_hour,
            'study_time' => $post->study_time,
            'study_date' => $post->study_date,
            'user_id' => $post->user_id,
        ]));
        
        $response = $this->actingAs($user)
        ->post(route('posts.update', ['post' => $post1]));

        $this->assertDatabaseHas('posts', [
            'title' => $post1->title,
            'content' => $post1->content,
            'study_hour' => $post1->study_hour,
            'study_time' => $post1->study_time,
            'study_date' => $post1->study_date,
            'user_id' => $post1->user_id,
        ]);

        $response->assertStatus(302);
        
    }

    public function testGuestDelete()
    {
        $post = factory(Post::class)->create();
        $user = $post->user;
        $response = $this->delete(route('posts.delete', ['post' => $post]));

        $response->assertRedirect(route('login'));
    }

    public function testAuthDelete()
    {
        $post = factory(Post::class)->create();
        $user = $post->user;
        $response = $this->actingAs($user)
        ->delete(route('posts.delete', ['post' => $post]))
        ->assertStatus(302)
        ->assertRedirect(route('posts.index'));
        //データベースに存在しない
        $this->assertDatabaseMissing('posts', [
            'title' => $post->title,
            'content' => $post->content,
            'study_hour' => $post->study_hour,
            'study_time' => $post->study_time,
            'study_date' => $post->study_date,
            'user_id' => $post->user_id,
        ]);
    }
}
