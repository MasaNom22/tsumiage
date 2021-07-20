<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use App\Post;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Illuminate\Http\Request;
use Session;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|max:255',
        ]);
        //use App\Postが必要
        $comment = new Comment();
        $comment->fill($request->all());
        //use Illuminate\Support\Facades\Authが必要
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->save();

        return Redirect::back()->with('comment_create_message','コメントを投稿しました。');
    }

    public function edit (Comment $comment)
    {
        return view('comments.edit',
        [
            'comment' => $comment,
        ]);
    }

    public function update (Comment $comment, CommentRequest $request)
    {
        $comment->fill($request->all())->save();
        $post = Post::where('id', $comment->post_id)->first();      
        $comments = Comment::where('post_id', $comment->post_id)->get();
        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function delete (Comment $comment)
    {
        $comment->delete();
        return Redirect::back()->with('comment_delete_message','コメントを削除しました。');
    }
}
