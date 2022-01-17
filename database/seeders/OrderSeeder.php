<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->delete();

        $orders = json_decode(file_get_contents(__DIR__ . '/../Data/orders.json'), true);

        foreach ($orders as $order){
            DB::table('orders')->insert([
                'id'=>$order['id'],
                'customer_id'=>$order['customerId'],
                'total'=>$order['total'],
            ]);

            foreach ($order['items'] as $product){
                DB::table('order_products')->insert([
                    'order_id'=>$order['id'],
                    'product_id'=>$product['productId'],
                    'quantity'=>$product['quantity'],
                    'unit_price'=>$product['unitPrice'],
                    'total'=>$product['total'],
                ]);
            }
        }
    }
}
