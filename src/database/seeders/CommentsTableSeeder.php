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
                'text' => 'カラオケで使うやつ！！'
            ],
            [
                'user_id' => 1,
                'item_id' => 7,
                'text' => '生前母が愛用していました'
            ],
            [
                'user_id' => 2,
                'item_id' => 1,
                'text' => '大好き！私の時計このブランドばかりよ'
            ],
            [
                'user_id' => 2,
                'item_id' => 2,
                'text' => 'ハウンドドッグ！(HDD)'
            ]
        ];

        DB::table('comments')->insert($params);
    }
}
