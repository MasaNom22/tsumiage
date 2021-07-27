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
        $user = User::where('id', $post->user_id)->first();
        $title = $post->title;
        $content = $post->content;
        $study_hour = $post->study_hour;
        $study_time = $post->study_time;
        $study_date = $post->study_date;
        $user_id = $post->user_id;

        $response = $this->actingAs($user)->post(route('posts.store', [
            'title' => $title,
            'content' => $content,
            'study_hour' => $study_hour,
            'study_time' => $study_time,
            'study_date' => $study_date,
            'user_id' => $user_id,
        ]));

        $response->assertRedirect(route('posts.index'));
        //登録したデータが存在するかどうか
        $this->assertDatabaseHas('posts', [
            'title' => $title,
            'content' => $content,
            'study_hour' => $study_hour,
            'study_time' => $study_time,
            'study_date' => $study_date,
            'user_id' => $user_id,
        ]);
    }
}
