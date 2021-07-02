@extends('layouts.app')

@section('title', $user->name.'のページ')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-1">
            <div class="card">
                <div class="d-inline-flex">
                    <div class="p-5 d-flex flex-column">
                        @if(isset($user->image))
                        <img src="{{ Storage::url($user->image) }}" class="rounded-circle" width="150"
                            height="150">
                        @else
                        <i class="fas fa-user-circle fa-9x mr-1"></i>
                        @endif
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="mb-0 font-weight-bold">{{ $user->name }}</h4>

                        </div>
                    </div>
                    
                    <div class="p-5 d-flex flex-column justify-content-start">
                        <div class="d-flex">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                <a href="{{ route('users.edit', ['user' => $user]) }}"
                                    class="btn btn-primary">プロフィールを編集する</a>
                                @else

                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">投稿数</p>
                                <span>{{ $posts_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロー数</p>
                                <span></span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロワー数</p>
                                <span></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start mt-4">
                            <div>{{ $user->self_introduction }}</div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection