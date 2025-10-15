<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'item_id' => 5
        ];

        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 1,
            'item_id' => 6
        ];

        DB::table('likes')->insert($param);
    }
}
