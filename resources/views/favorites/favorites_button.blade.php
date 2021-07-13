@if ($post->isFavoritedBy(Auth::user()))
{{-- unfavoriteボタンのフォーム --}}
{!! Form::open(['route' => ['favorites.unlike', $post], 'method' => 'delete']) !!}
{!! Form::submit('お気に入りを外す', ['class' => "btn btn-danger"]) !!}
{!! Form::close() !!}
@else
{{-- favoriteボタンのフォーム --}}
{!! Form::open(['route' => ['favorites.like', $post], 'method' => 'post']) !!}
{!! Form::submit('お気に入り', ['class' => "btn btn-danger"]) !!}
{!! Form::close() !!}
@endif