<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            [
                'user_id' => 1,
                'item_id' => 6,
                'text' => '前から欲しかったやつ！！'
            ],
            [
                'user_id' => 1,
                'item_id' => 7,
                'text' => '青だったら買ったんだけどな。'
            ],
            [
                'user_id' => 2,
                'item_id' => 1,
                'text' => 'このブランド大好き！'
            ],
            [
                'user_id' => 2,
                'item_id' => 2,
                'text' => '色違い持ってる。おすすめよ。'
            ]
        ];

        DB::table('comments')->insert($params);
    }
}
