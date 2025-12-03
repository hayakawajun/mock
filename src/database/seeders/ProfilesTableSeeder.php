<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfilesTableSeeder extends Seeder
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
                'postal_code' => '123-4567',
                'address' => '東京都南東京市西北町1-2-3',
                'building' => 'ダミービル101',
                'image' => 'profile_image/dummy1.png'
            ],
            [
            'user_id' => 2,
            'postal_code' => '987-6543',
            'address' => '群馬県群馬市群馬町9-9-9',
            'building' => '',
            'image' => 'profile_image/dummy2.png'
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

        DB::table('profiles')->insert($params);
    }
}