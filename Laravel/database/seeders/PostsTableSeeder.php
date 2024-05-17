<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('posts')->insert([

            ['contents' => '１つ目の投稿になります', 'user_name' => 'ユーサー1'],

            ['contents' => '2つ目の投稿になります', 'user_name' => 'ユーサー2'],

            ['contents' => '3つ目の投稿になります', 'user_name' => 'ユーサー3'],
        ]);
    }
}
