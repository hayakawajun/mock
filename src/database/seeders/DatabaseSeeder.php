<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ProfilesTableSeeder::class,
            ItemsTableSeeder::class,
            CategoriesTableSeeder::class,
            Item_categoryTableSeeder::class,
            CommentsTableSeeder::class,
            LikesTableSeeder::class,
            PurchasesTableSeeder::class
        ]);
    }
}
