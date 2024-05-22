@extends('layouts.app')

<!DOCTYPE html>

<html>



<body>
@section('content')


<div class='container'>

  <h2 class='page-header'>新しく投稿する</h2>

  {!! Form::open(['url' => 'post/create']) !!}



  <div class="form-group">

    {!! Form::input('text', 'contents', null, ['required', 'class' => 'form-control', 'placeholder' => '投稿内容','pattern'=>'^[\S\s]*\S[\S\s]*$','title'=>'全角スペースのみは投稿できません。']) !!}

  </div>

    <button type="submit" class="btn btn-success pull-right">追加</button>

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
