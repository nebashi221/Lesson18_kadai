@extends('layouts.app')

<!DOCTYPE html>


<html>




<body>

  @section('content')



  <div class='container'>

      <h2 class='page-header'>投稿内容を変更する</h2>

      {!! Form::open(['url' => '/post/update']) !!}




    <div class="form-group">

      {!! Form::hidden('id', $post->id) !!}

      {!! Form::input('text', 'contents', $post->contents, ['required', 'class' => 'form-control','placehoder'=>'投稿内容']) !!}

    </div>

    <button type="submit" class="btn btn-primary pull-right">更新</button>

     {!! Form::close() !!}

  </div>

  @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

   @endsection


 </body>


</html>
