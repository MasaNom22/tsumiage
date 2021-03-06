<div class="row">
  <div class="col-md mb-4">
    <div class="card article-card">
      <div class="card-body d-flex flex-row row">
        <div class="col-2">
          @if(isset($post->user->image))
          <a href="{{ route('users.show', ['user' => $post->user]) }}" class="text-dark">
            <img class="user-icon rounded-circle" src="{{ Storage::url($post->user->image) }}"
              width="60" height="60"  alt="写真" />
          </a>
          @else
          <a href="{{ route('users.show', ['user' => $post->user]) }}" class="text-dark">
            <i class="fas fa-user-circle fa-3x mr-1"></i>
          </a>
          @endif
        </div>
        <div style="" class="col-8">
          <h5 class="">
            <a href="{{ route('users.show', ['user' => $post->user]) }}" class="text-dark">
              {{ $post->user->name }} 
            </a>
          </h5>
          <h6 class="font-weight-lighter">投稿日時: {{ $post->created_at->format('Y/m/d') }}</h6>
          <a class="text-dark" href="{{ route('posts.show', ['post' => $post]) }}">
            <h4> {{ $post->title }}</h4>
          </a>
          
          
        </div>
        
        <!-- dropdown -->
        @if ($post->user_id == Auth::id())
        <div class="col-1 card-text">
          <div class="dropdown text-center">
            <a class="in-link p-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-lg"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('posts.edit', ['post' => $post]) }}">
                <i class="fas fa-pen mr-1"></i>投稿を編集する
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $post->id }}">
                <i class="fas fa-trash-alt mr-1"></i>記事を削除する
              </a>
                                  </div>

          </div>
        </div>
                  <!-- modal -->
                  <div id="modal-delete-{{ $post->id }}" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="POST" action="{{ route('posts.delete', ['post' => $post]) }}">
                          @csrf
                          @method('DELETE')
                          <div class="modal-body">
                            {{ $post->title }}を削除します。よろしいですか？
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
      <div class="card-body pt-0 pb-2 pl-3">
        @include ('favorites.favorites_button')
      </div>
    </div>
  </div>
</div>