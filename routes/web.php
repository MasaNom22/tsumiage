<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'PostController@index')->name('posts.index');

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('users')->name('users.')->group(function () {
    //ユーザー詳細画面
    Route::get('/{user}', 'UserController@show')->name('show')->middleware('auth');
    //ユーザー編集画面
    Route::get('/edit/{user}', 'UserController@edit')->name('edit')->middleware('auth');
    //ユーザー編集画面
    Route::patch('/update/{user}', 'UserController@update')->name('update')->middleware('auth');
    //フォロー機能
    Route::post('/follow/{user}', 'UserController@follow')->name('follow')->middleware('auth');
    //アンフォロー機能
    Route::delete('/unfollow/{user}', 'UserController@unfollow')->name('unfollow')->middleware('auth');
});

Route::prefix('posts')->name('posts.')->group(function () {
    //投稿画面
    Route::get('/create', 'PostController@create')->name('create')->middleware('auth');
    //登録機能
    Route::post('/store', 'PostController@store')->name('store')->middleware('auth');
    //投稿詳細画面
    Route::get('/show/{post}', 'PostController@show')->name('show');
    //投稿編集画面
    Route::get('/edit/{post}', 'PostController@edit')->name('edit')->middleware('auth');
    //投稿更新
    Route::post('/update/{post}', 'PostController@update')->name('update')->middleware('auth');
    //削除機能
    Route::delete('/delete/{post}', 'PostController@delete')->name('delete')->middleware('auth');
});

Route::prefix('comments')->name('comments.')->group(function () {
    //登録機能
    Route::post('/{post}/store', 'CommentController@store')->name('store')->middleware('auth');
    //投稿編集画面
    Route::get('/edit/{comment}', 'CommentController@edit')->name('edit')->middleware('auth');
    //投稿更新
    Route::post('/update/{comment}', 'CommentController@update')->name('update')->middleware('auth');
    //削除機能
    Route::delete('/delete/{comment}', 'CommentController@delete')->name('delete')->middleware('auth');
});

Route::prefix('favorites')->name('favorites.')->group(function () {
    Route::post('/{post}/like', 'PostController@favorite')->name('like')->middleware('auth');
    Route::delete('/{post}/like', 'PostController@unfavorite')->name('unlike')->middleware('auth');
});
