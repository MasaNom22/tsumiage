<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Redirect;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts_count = $user->posts()->count();
        // ユーザのフォロワーをカウントを取得
        $user->loadCount('followers');
        // ユーザのフォローユーザーを取得
        $user->loadCount('followings');
        return view('users.show', [
            'user' => $user,
            'posts_count' => $posts_count,
        ]);
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'image'=>'file|image|mimes:png,jpeg,jpg|max:2048',
        ]);
        $upload_image = $request->file('image');

        $user->name = $request->name;
        $user->email = $request->email;
        $user->self_introduction = $request->self_introduction;
        if($upload_image) {
            $file_name = $upload_image->getClientOriginalName();
            $path = $upload_image->storeAs('public/images', $file_name);
            $user->image = $path;
        } else {
            $file_name = "";
        }
        $user->save();
        //use Redirectが必要
        return Redirect::back()->with('update_profile_message', 'プロフィールを更新しました。');
    }

    public function follow(Request $request, User $user)
    {

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user->id);
        $request->user()->followings()->attach($user->id);

        return Redirect::back()->with('follow_message', 'フォローしました。');
    }

    public function unfollow(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user->id);

        return Redirect::back()->with('unfollow_message', 'フォローを外しました。');
    }

}
