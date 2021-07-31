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
    public function index(Request $request)
    {
        $keyword = $request->input('title');
        $all_posts = Post::All()->sortByDesc('created_at');

        if (!empty($keyword)) {
            $all_posts = Post::where('title', 'like', '%' . $keyword . '%')->get();
        }

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
        $comments = Comment::where('post_id', $post->id)->get();
        
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

    public function download_csv(Request $request)
    {

        return response()->streamDownload(
            function () {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');
                // ヘッダー
                fputcsv($stream, [
                    '名前',
                    '記事内容',
                    '投稿日',
                    '勉強(時間)',
                    '勉強(分)',
                ]);
                $all_posts = Post::all()->sortByDesc('created_at');
                // データ
                foreach ($all_posts as $post) {
                    fputcsv($stream, [
                        $post->title,
                        $post->content,
                        $post->study_date,
                        $post->study_hour,
                        $post->study_time                        
                    ]);
                }
                fclose($stream);
            },
            '投稿一覧.csv',
            [
                'Content-Type' => 'application/octet-stream',
            ]
        );
    }

}
