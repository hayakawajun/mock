<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ItemsTableSeeder extends Seeder
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
                'name' => '腕時計',
                'bland' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'status' => 1,
                'price' => 15000,
                'image' => 'item_image/Armani+Mens+Clock.jpg'
            ],
            [
                'user_id' => 1,
                'name' => 'HDD',
                'bland' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'status' => 2,
                'price' => 5000,
                'image' => 'item_image/HDD+Hard+Disk.jpg'
            ],
            [
                'user_id' => 1,
                'name' => '玉ねぎ3束',
                'bland' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'status' => 3,
                'price' => 300,
                'image' => 'item_image/iLoveIMG+d.jpg'
            ],
            [
                'user_id' => 1,
                'name' => '革靴',
                'bland' => '',
                'description' => 'クラシックなデザインの革靴',
                'status' => 4,
                'price' => 4000,
                'image' => 'item_image/Leather+Shoes+Product+Photo.jpg'
            ],
            [
                'user_id' => 1,
                'name' => 'ノートPC',
                'bland' => '',
                'description' => '高性能なノートパソコン',
                'status' => 1,
                'price' => 45000,
                'image' => 'item_image/Living+Room+Laptop.jpg'
            ],
            [
                'user_id' => 2,
                'name' => 'マイク',
                'bland' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'status' => 2,
                'price' => 8000,
                'image' => 'item_image/Music+Mic+4632231.jpg'
            ],
            [
                'user_id' => 2,
                'name' => 'ショルダーバッグ',
                'bland' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'status' => 3,
                'price' => 3500,
                'image' => 'item_image/Purse+fashion+pocket.jpg'
            ],
            [
                'user_id' => 2,
                'name' => 'タンブラー',
                'bland' => 'なし',
                'description' => '使いやすいタンブラー',
                'status' => 4,
                'price' => 500,
                'image' => 'item_image/Tumbler+souvenir.jpg'
            ],
            [
                'user_id' => 2,
                'name' => 'コーヒーミル',
                'bland' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'status' => 1,
                'price' => 4000,
                'image' => 'item_image/Waitress+with+Coffee+Grinder.jpg'
            ],
            [
                'user_id' => 2,
                'name' => 'メイクセット',
                'bland' => '',
                'description' => '便利なメイクアップセット',
                'status' => 2,
                'price' => 2500,
                'image' => 'item_image/外出メイクアップセット.jpg'
            ]
        ];

        foreach($params as $param){
            $sourceFileName = basename($param['image']);
            $sourcePath = public_path('image/seeder/'.$sourceFileName);
            $destinationPath = storage_path('app/public/'.$param['image']);

            if(File::exists($sourcePath)){
                File::ensureDirectoryExists(dirname($destinationPath));
                File::copy($sourcePath,$destinationPath);
            }
        }

        DB::table('items')->insert($params);
    }
}
