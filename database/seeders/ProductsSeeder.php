<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();

        $products = json_decode(file_get_contents(__DIR__ . '/../Data/products.json'), true);

        foreach ($products as $product){
            DB::table('products')->insert([
                'id'=>$product['id'],
                'name'=>$product['name'],
                'category_id'=>$product['category'],
                'price'=>$product['price'],
                'stock'=>$product['stock']
            ]);
        }
    }
}
