@extends('layouts.app')

<!DOCTYPE html>

<html>

  <body>
    @section('content')

    <div class='container'>


      <h2>投稿一覧</h2>


      <form method="POST" action="/post/search">

      @csrf
      <div class="form-group">

        <input type="text" name="keyword" class="form-control" placeholder="検索キーワード">

      </div>

      <button type="submit" class="btn btn-primary">検索</button>

      </form>

      @if(count($lists) == 0 && isset($keyword))
      <p>検索結果が見つかりませんでした。</p>

      @else

      <table class="table table-hover">

        <tr>

          <th>投稿No</th>

          <th>投稿者</th>

          <th>投稿内容</th>

          <th>投稿日時</th>

          <th>更新日時</th>

        </tr>

        @foreach ($lists as $list)

        <tr>

          <td>{{$list->id}}</td>

          <td>{{$list->user_name}}</td>

          <td>{{$list->contents}}</td>

          <td>{{$list->created_at}}</td>

          <td>{{$list->updated_at}}</td>


          @if(isset($list->editable) && $list->editable)

          <td><a class="btn btn-primary" href="/post/{{ $list->id }}/update-form">編集</a></td>

          <td><a class="btn btn-danger" href="/post/{{ $list->id }}/delete"

               onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか？')">削除</a></td>
           @endif


        </tr>

        @endforeach

      </table>

      @endif

      <p class="pull-right"><a class="btn btn-success" href="/create-form">投稿する</a></p>

    </div>
    @endsection

      <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bpptstrap/3.3.1/js/bootstrap.mim.js"></script>

  </body>

</html>
