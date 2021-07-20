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
      <div class="card mt-3">
        <h2 class="h4 card-header text-center aqua-gradient text-white">コメント投稿画面</h2>
        <!-- 投稿のフォーム -->
        <form id="nomal-post" method="POST" class="w-75 mx-auto"
          action="{{ route('comments.store', ['post' => $post]) }}">
          @csrf
          <div class="form-group">
            <label></label>
            @error('comment')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <textarea name="comment" class="form-control" rows="8" placeholder="コメント">{{ old('body') }}</textarea>

          </div>
        </form>

        <div class="w-75 mx-auto d-flex justify-content-between align-items-start">
          <!-- 通常の投稿ボタン -->
          <div style="width:45%">
            <button form="nomal-post" type="submit" class="btn btn-block aqua-gradient mb-1">
              <span class="h6">コメントする</span>
          </div>
        </div>

      </div>

      <div class="card mt-3">
        <h2 class="h4 card-header text-center aqua-gradient text-white">コメント詳細</h2>
        @foreach($comments as $comment)
        <div class="card-body pt-3">
          <div class="text-center mt-3">
          </div>

          <h4>{{ $comment->user->name }}</h4>
          <div>{{ $comment->comment }}</div>


          @if ($comment->user_id == Auth::id())
          <div class="col-1 card-text">
            <div class="dropdown text-center">
              <a class="in-link p-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-lg"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('comments.edit', ['comment' => $comment]) }}">
                  <i class="fas fa-pen mr-1"></i>コメントを編集する
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $comment->id }}">
                  <i class="fas fa-trash-alt mr-1"></i>コメントを削除する
                </a>
              </div>

            </div>
          </div>
          <!-- modal -->
          <div id="modal-delete-{{ $comment->id }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST" action="{{ route('comments.delete', ['comment' => $comment]) }}">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body">
                    コメントを削除します。よろしいですか？
                  </div>
                  <div class="modal-footer justify-content-between">
                    <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                    <button type="submit" class="btn btn-danger">削除する</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- modal -->
          @endif
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
  @if (session('comment_create_message'))
      $(function () { 
        toastr.options =
  {
  	"closeButton" : true,
    //"positionClass": "toast-bottom-right",
  	"progressBar" : true,
    "timeOut": "1200",
  }
              toastr.success('{{ session('comment_create_message') }}');
      });
  @endif
  @if (session('comment_delete_message'))
      $(function () { 
        toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true,
    "timeOut": "1200",
  }
              toastr.success('{{ session('comment_delete_message') }}');
      });
  @endif

</script>
@endsection