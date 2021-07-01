@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
<div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card">
          <h2 class="h4 card-header text-center aqua-gradient text-white">プロフィール編集</h2>
          <div class="card-body">

            <div class="user-form my-4">
              <form method="POST" action="{{ route('users.update', ['user' => $user]) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                
                <div class="form-group text-center">
                  <label for="profile_image">
                    <p class="mb-1">プロフィール画像</p>
                    
                  </label>
                </div>
                <div class="form-group">
                  <label for="name">ユーザー名</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $user->name ?? old('name') }}">
                </div>
                <div class="form-group">
                  <label for="email">メールアドレス</label>
                    <input class="form-control" type="text" id="email" name="email" value="{{ $user->email ?? old('email') }}">
                </div>
                <div class="form-group">
                  <label for="self_introduction">自己紹介文</label>
                    <textarea class="form-control" type="textarea" cols="40" rows="5" id="self_introduction" name="self_introduction">{{ $user->self_introduction  }}</textarea>
                </div>
                

                <div class="d-flex justify-content-between align-items-center">
                  <button class="btn aqua-gradient mt-2 mb-2" type="submit">
                    <span class="h6">保存</span>
                  </button>
                  
                </div>
              </form>
            </div>
          </div>
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
  @if (session('update_profile_message'))
      $(function () { 
        toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true,
    "timeOut": "1200",
  }
              toastr.success('{{ session('update_profile_message') }}');
      });
  @endif
</script>
@endsection