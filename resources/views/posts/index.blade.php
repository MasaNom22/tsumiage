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
</script>
@endsection
