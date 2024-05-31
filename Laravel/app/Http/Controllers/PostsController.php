<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    //
    public function index()
    {
        $list = DB::table('posts')->get();
        $userName = Auth::check() ? Auth::user()->name : null;

        $keyword = request()->input('keyword');

        if ($keyword) {
            $lists = DB::table('posts')->where('contents', 'like', '%' . $keyword . '%')->get();
        } else {
            $lists = DB::table('posts')->get();
        }

        foreach ($lists as $post) {
            $post->editable = $userName == $post->user_name;
        }

        if (count($lists) == 0 && !$keyword) {
            return view('posts.index', ['lists' => $lists, 'username' => $userName]);
        } elseif (count($lists) == 0 && $keyword) {
            return view('posts.index', ['lists' => $lists, 'username' => $userName, 'keyword' => $keyword]);
        }

        return view('posts.index', ['lists' => $lists, 'username' => $userName]);
    }
    public function createForm()
    {
        return view('posts.createForm');
    }

    public function create(Request $request)

    {

        $request->validate(['contents' => 'required', 'string', 'max:100', 'regex:/[^\s　]/']);

        $userName = $request->user()->name;
        $contents = $request->input('contents');

        if (mb_strlen($contents) > 100) {
            return redirect()->back()->with('error', '投稿内容100文字以内で入力してください。');
        }

        if (preg_match('/^　+$/u', $contents)) {
            return redirect()->back()->with('error', '投稿内容を入力してください。');
        }

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
        $request->validate(['contents' => 'required|regex:/[^\s　]/|max:100']); //投稿内容が空欄またはスペースのみ、１００文字以上だとエラーが出る

        $id = $request->input('id');

        $contents = $request->input('contents');

        if (mb_strlen(trim($contents)) === 0) {
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

        $userName = Auth::check() ? Auth::user()->name : null;

        if ($keyword) {
            $lists = DB::table('posts')->where('contents', 'like', '%' . $keyword . '%')->get();
        } else {
            $lists = DB::table('posts')->get();
        }

        foreach ($lists as $post) {
            $post->editable = $userName == $post->user_name;
        }

        if (count($lists) == 0 && $keyword) {
            return view('posts.index', ['lists' => $lists, 'username' => $userName, 'keyword' => $keyword]);
        }

        return view('posts.index', ['lists' => $lists, 'username' => $userName, 'keyword' => null]);
    }

    public function __construct()

    {

        $this->middleware('auth');
    }
}
