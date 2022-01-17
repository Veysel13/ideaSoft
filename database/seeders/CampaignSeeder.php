<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campaigns')->insert([
            'type'=>'order_discount',
            'min_price'=>1000,
            'discount'=>10,
            'quantity'=>0,
            'status'=>1,
        ]);

        DB::table('campaigns')->insert([
            'type'=>'category_product_discount',
            'type_id'=>6,
            'min_price'=>0,
            'discount'=>0,
            'quantity'=>6,
            'status'=>1,
        ]);

        DB::table('campaigns')->insert([
            'type'=>'category_cheapest_discount',
            'type_id'=>1,
            'min_price'=>0,
            'discount'=>20,
            'quantity'=>2,
            'status'=>1,
        ]);
    }
}
