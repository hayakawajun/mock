<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
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
            'postal_code' => '123-4567',
            'address' => '東京都南東京市西北町1-2-3',
            'building' => 'ダミービル101',
            'image' => 'profile_image/dummy1.png'
        ];

        DB::table('profiles')->insert($param);

        $param = [
            'user_id' => 2,
            'postal_code' => '987-6543',
            'address' => '群馬県群馬市群馬町9-9-9',
            'image' => 'profile_image/dummy2.png'
        ];

        DB::table('profiles')->insert($param);
    }
}
