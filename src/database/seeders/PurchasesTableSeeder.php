<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PurchasesTableSeeder extends Seeder
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
            'item_id' => 6,
            'payment' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都南東京市西北町1-2-3',
            'building' => 'ダミービル101'
        ];

        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => 1,
            'item_id' => 9,
            'payment' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都南東京市西北町1-2-3',
            'building' => 'ダミービル101'
        ];

        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => 2,
            'item_id' => 1,
            'payment' => 'コンビニ払い',
            'postal_code' => '987-6543',
            'address' => '群馬県群馬市群馬町9-9-9'
        ];

        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => 2,
            'item_id' => 4,
            'payment' => 'カード払い',
            'postal_code' => '987-6543',
            'address' => '群馬県群馬市群馬町9-9-9'
        ];

        DB::table('purchases')->insert($param);
    }
}
