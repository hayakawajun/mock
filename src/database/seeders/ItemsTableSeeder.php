<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
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
            'name' => '腕時計',
            'bland' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'status' => 1,
            'price' => 15000,
            'image' => 'image/Armani+Mens+Clock.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'name' => 'HDD',
            'bland' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'status' => 2,
            'price' => 5000,
            'image' => 'image/HDD+Hard+Disk.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'name' => '玉ねぎ3束',
            'bland' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'status' => 3,
            'price' => 300,
            'image' => 'image/iLoveIMG+d.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'name' => '革靴',
            'description' => 'クラシックなデザインの革靴',
            'status' => 4,
            'price' => 4000,
            'image' => 'image/Leather+Shoes+Product+Photo.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'name' => 'ノートPC',
            'description' => '高性能なモートパソコン',
            'status' => 1,
            'price' => 45000,
            'image' => 'image/Living+Room+Laptop.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 2,
            'name' => 'マイク',
            'bland' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'status' => 2,
            'price' => 8000,
            'image' => 'image/Music+Mic+4632231.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 2,
            'name' => 'ショルダーバッグ',
            'description' => 'おしゃれなショルダーバッグ',
            'status' => 3,
            'price' => 3500,
            'image' => 'image/Purse+fashion+pocket.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 2,
            'name' => 'タンブラー',
            'bland' => 'なし',
            'description' => '使いやすいタンブラー',
            'status' => 4,
            'price' => 500,
            'image' => 'image/Tumbler+souvenir.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 2,
            'name' => 'コーヒーミル',
            'bland' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'status' => 1,
            'price' => 4000,
            'image' => 'image/Waitress+with+Coffee+Grinder.jpg'
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 2,
            'name' => 'メイクセット',
            'description' => '便利なメイクアップセット',
            'status' => 2,
            'price' => 2500,
            'image' => 'image/外出メイクアップセット.jpg'
        ];
        DB::table('items')->insert($param);
    }
}
