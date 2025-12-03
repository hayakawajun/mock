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
        $params = [
            [
                'name' => 'ダミ男',
                'email' => 'dummy1@test.com',
                'email_verified_at' => '2025-01-01 00:00:01',
                'password' => Hash::make('dummypass')
            ],
            [
                'name' => 'ダミ子',
                'email' => 'dummy2@test.com',
                'email_verified_at' => '2025-01-01 00:00:02',
                'password' => Hash::make('dummypass')
            ]
        ];

        DB::table('users')->insert($params);
    }
}
