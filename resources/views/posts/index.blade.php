@extends('layouts.app')

@section('title', 'トップページ')

@if (Auth::check())
@section('content')

<div class="container mt-4">
  <div class="row d-flex justify-content-center">
    <div class="row col-md-12 d-flex">
        <div class="col-md-5">
      <form action="{{ url('/')}}" method="get" class="">
        {{ csrf_field()}}
        {{method_field('get')}}
          <div class="form-group">
              <label>タイトル検索</label>                    
              <input type="text" class="form-control" placeholder="検索したいタイトルを入力してください" name="title" value="">
          </div>
          <button type="submit" class="btn btn-primary">検索</button>
      </form>
      <a class="btn btn-primary " href={!! route('posts.CsvDownload') !!}>投稿一覧CSV出力</a>
    </div>

      <main class="col-md-7">
        @foreach($posts as $post)
        @include('posts.card')
        @endforeach

      </main>

    </div>
  </div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
  @if (session('delete_message'))
      $(function () { 
        toastr.options =
  {
  	"closeButton" : true,
    //"positionClass": "toast-bottom-right",
  	"progressBar" : true,
    "timeOut": "1200",
  }
              toastr.success('{{ session('delete_message') }}');
      });
  @endif
  @if (session('favorite_message'))
      $(function () { 
        toastr.options =
  {
  	"closeButton" : true,
    //"positionClass": "toast-bottom-right",
  	"progressBar" : true,
    "timeOut": "1200",
  }
              toastr.success('{{ session('favorite_message') }}');
      });
  @endif
</script>
@endsection
@else

@section('content')

<!-- 1.モーダル表示のためのボタン -->
<button class="btn btn-primary" data-toggle="modal" data-target="#modal-example">
  モーダルダイアログ表示
</button>
<!-- 2.モーダルの配置 -->
<div class="modal" id="modal-example" tabindex="-1">
  <div class="modal-dialog">

    <!-- 3.モーダルのコンテンツ -->
    <div class="modal-content">

      <!-- 4.モーダルのヘッダ -->
      <div class="modal-header">
        <h4 class="modal-title text-center" id="modal-label">新規登録</h4>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>

      <!-- 5.モーダルのボディ -->
      <div class="modal-body">
        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('名前') }}
              <small class="text-danger">（必須）</small></label>

            <div class="col-md-6">
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>

              @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}
              <small class="text-danger">（必須）</small></label>

            <div class="col-md-6">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" placeholder="例）abc@gmail.com">

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}
              <small class="text-danger">（必須）</small></label>

            <div class="col-md-6">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password" placeholder="※4文字以上">

              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>



          <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
              <button type="submit" class="btn btn-primary">
                {{ __('新規登録') }}
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- 6.モーダルのフッタ -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
        <button type="button" class="btn btn-primary">保存</button>
      </div>
    </div>
  </div>

  @endsection

  @endif