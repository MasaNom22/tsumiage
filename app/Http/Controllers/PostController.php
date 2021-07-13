<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;

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

        $all_posts = Post::All()->sortByDesc('created_at');

        return view('posts.index', [
            'posts' => $all_posts,
        ]);
    }
    
    public function show (Post $post)
    {
        $comments = Comment::where('post_id', $post->id);
        
        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
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
        $post->fill($request->all())->save();
        //use Redirectが必要
        return Redirect::back()->with('update_message','積み上げ内容を更新しました。');
    }

    public function delete(Post $post)
    {
        $post->delete();
        
        return Redirect::back()->with('delete_message','積み上げ内容を削除しました。');
    }

    public function favorite(Request $request, Post $post)
    {
        $post->favorites()->detach($request->user()->id);
        $post->favorites()->attach($request->user()->id);

        return Redirect::back()->with('favorite_message','お気に入りに登録しました。');
    }

    public function unfavorite(Request $request, Post $post)
    {
        $post->favorites()->detach($request->user()->id);

        return Redirect::back()->with('favorite_message','お気に入りを解除しました。');
    }

}
