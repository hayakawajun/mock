<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'ダミ男',
            'email' => 'dummy1@test.com',
            'password' => Hash::make('dummypass')
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'ダミ子',
            'email' => 'dummy2@test.com',
            'password' => Hash::make('dummypass')
        ];
        DB::table('users')->insert($param);
    }
}
