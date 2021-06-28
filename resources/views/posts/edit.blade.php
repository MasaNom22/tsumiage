@extends('layouts.app')

@section('title', '投稿編集画面')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

@endsection

@section('content')
<div class="container my-5">
  <div class="row">
    <div class="mx-auto col-md-8">
      <div class="card">
        <h2 class="h4 card-header text-center aqua-gradient text-white">{{ Auth::user()->name }}さんの投稿画面</h2>
        <div class="card-body pt-3">
          <div class="text-center mt-3">

          </div>
          <div class="card-text">
            <!-- 投稿のフォーム -->
            <form id="nomal-post" method="POST" class="mx-auto"
              action="{{  route('posts.update', ['post' => $post])  }}">
              <table>
                <tr>
                  <th>タイトル</th>
                  <td><input type="text" class="form-control" name="title" id="title" value="{{ $post->title }}" /></td>

                </tr>
                @error('title')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
                <tr>
                  <th>学習日</th>
                  <td><input type="text" class="form-control" name="study_date" id="study_date"
                      value="{{ $post->study_date }}" /></td>
                  @error('study_date')
                  <div class="alert alert-danger">{{$message}}</div>
                  @enderror
                </tr>
                <tr class="text-center">
                  <th>学習時間</th>
                  <td class="select"><select name="study_hour">
                      @for ($i = 1; $i <= 23; $i ++) <option value={{ $i  }}>{{ $i }}</option>
                        @endfor
                        <option value={{ $post->study_hour }} selected>{{ $post->study_hour}}</option>
                    </select>時間</td>
                  <td class="select">
                    <select name="study_time">
                      @for ($i = 0; $i <= 45; $i +=15) <option value={{ $i  }}>{{ $i }}</option>
                        @endfor
                        <option value={{ $post->study_time }} selected>{{ $post->study_time}}</option>
                    </select>分</td>
                </tr>

              </table>

              @csrf
              <div class="form-group">
                <label></label>
                <textarea name="content" class="form-control" rows="8" placeholder="本文">{{  $post->content }}</textarea>
                @error('content')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
              </div>

            </form>

            <div class="w-75 mx-auto d-flex justify-content-between align-items-start">
              <!-- 通常の投稿ボタン -->
              <div style="width:45%">
                <button form="nomal-post" type="submit" class="btn btn-block aqua-gradient">
                  <span class="h6">更新する</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<script>
  flatpickr(document.getElementById('study_date'), {
      locale: 'ja',
      dateFormat: "Y/m/d",
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
  @if (session('flash_message'))
      $(function () { 
        toastr.options =
  {
  	"closeButton" : true,
    //"positionClass": "toast-bottom-right",
  	"progressBar" : true,
    "timeOut": "2000",
  }
              toastr.success('{{ session('flash_message') }}');
      });
  @endif
</script>
@endsection