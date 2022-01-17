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
            CustomerSeeder::class,
            ProductsSeeder::class,
            OrderSeeder::class,
            CampaignSeeder::class,
        ]);
    }
}
