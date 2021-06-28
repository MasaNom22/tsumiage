<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

class PostController extends Controller
{
    public function index()
    {
        $all_posts = Post::All()->sortByDesc('created_at');

        return view('posts.index', [
            'posts' => $all_posts,
        ]);
    }
    public function create ()
    {
        //use Illuminate\Support\Facades\Auth;が必要
        $user = Auth::user();

        return view ('posts.create', [
            'user' => $user,
        ]);
    }
    
    public function store (PostRequest $request)
    {
        //use App\Postが必要
        $post = new Post();
        $post->fill($request->all());
        $post->user_id = $request->user()->id;
        $post->save();

        return view('/home');
    }
    
    public function show (Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function edit (Post $post)
    {
        return view ('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update (Post $post, PostRequest $request)
    {
        $post->title = $request->title;
        $post->study_date = $request->study_date;
        $post->study_hour = $request->study_hour;
        $post->study_time = $request->study_time;
        $post->content = $request->content;
        $post->save();

        return Redirect::back()->with('flash_message','積み上げ内容を更新しました。');
    }
}
