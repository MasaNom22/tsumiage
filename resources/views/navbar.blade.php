<header class="mb-4">
  <nav class="navbar navbar-expand-sm navbar-dark aqua-gradient">
    {{-- トップページへのリンク --}}
    <a class="navbar-brand" href="/"><i class=""></i>積み上げアプリ</a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav-bar">
      <ul class="navbar-nav mr-auto"></ul>
      <ul class="navbar-nav">
        @if (Auth::check())
        <li class="nav-item">
          <span class="nav-link">ようこそ、 {{ Auth::user()->name }}さん</span>
        </li>
        {{-- 新規登録ページへのリンク --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('posts.create') }}"><i class="fas fa-pen mr-1"></i>投稿</a>
        </li>
        {{-- ログアウトへのリンク --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}">ログアウト</a>
      </li>
        
              {{-- マイページへのリンク --}}
              <li class="nav-item">
                <a class="nav-link" href="{{ route('users.show', ['user' => Auth::user()]) }}"></i>マイページ</a>
            </li>

        @else
        
        {{-- 新規登録ページへのリンク --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">ユーザー登録</a>
        </li>
        {{-- ログインページへのリンク --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">ログイン</a>
        </li>
        @endif
      </ul>
    </div>
  </nav>
</header>