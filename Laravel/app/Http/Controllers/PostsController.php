<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    //
    public function index()
    {
        $list = DB::table('posts')->get();
        return view('posts.index', ['lists' => $list]);
    }

    public function createForm()
    {
        return view('posts.createForm');
    }

    public function create(Request $request)

    {

        $userName = $request->user()->name;
        $contents = $request->input('contents');

        DB::table('posts')->insert([
            'user_name' => $userName,
            'contents' => $contents
        ]);

        return redirect('/index');
    }

    public function updateForm($id)

    {

        $post = DB::table('posts')

            ->where('id', $id)

            ->first();

        return view('posts.updateForm', ['post' => $post]);
    }

    public function update(Request $request)

    {
        $request->validate(['contents' => 'required|regex:/[^\s]/|max:100']); //投稿内容が空欄またはスペースのみ、１００文字以上だとエラーが出る

        $id = $request->input('id');

        $contents = $request->input('contents');

        if (empty(trim($contents))) {
            return redirect()->back()->with('error', '投稿内容を入力してください。');
        }

        DB::table('posts')

            ->where('id', $id)

            ->update(
                [
                    'contents' => $contents,
                    'updated_at' => DB::raw('CURRENT_TIMESTAMP')
                ]
            );

        return redirect('/index');
    }

    public function delete($id)

    {

        DB::table('posts')

            ->where('id', $id)

            ->delete();



        return redirect('/index');
    }

    public function search(Request $request)

    {
        $keyword = $request->input('keyword');

        if ($keyword) {
            $lists = DB::table('posts')->where('contents', 'like', '%' . $keyword . '%')->get();
        } else {
            $lists = [];
        }

        return view('posts.index', ['lists' => $lists]);
    }

    public function __construct()

    {

        $this->middleware('auth');
    }
}
