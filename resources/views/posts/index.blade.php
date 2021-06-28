@extends('layouts.app')

@section('title', 'トップページ')

@section('content')

<div class="container mt-4">
  <div class="row d-flex justify-content-center">
    <div class="row col-md-12">
      
      <main class="col-md-7 offset-md-5">
          @foreach($posts as $post)
            @include('posts.card')
            @endforeach

        </main>
    </div>
  </div>
</div>	                    

@endsection
