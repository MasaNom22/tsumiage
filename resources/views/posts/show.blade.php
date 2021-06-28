@extends('layouts.app')

@section('title', 'コメント詳細画面')

@section('content')
  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-8">
        <div class="card">
          <h2 class="h4 card-header text-center aqua-gradient text-white">{{ $post->user->name }}さんの投稿詳細</h2>
          <div class="card-body pt-3">
            <div class="text-center mt-3">                       
            </div>
            <div class="card-text">
              <!-- 投稿のフォーム -->
              <h4>{{ $post->title }}</h4>
              <h5>日時{{ $post->study_date }}</h5>
              <h5>勉強時間{{ $post->study_hour }}時間{{ $post->study_time }}分</h5>
            <div>{{ $post->content }}</div>
            

              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

