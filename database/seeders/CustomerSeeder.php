<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('customers')->delete();

        $customers = json_decode(file_get_contents(__DIR__ . '/../Data/customers.json'), true);

        foreach ($customers as $customer){
            DB::table('customers')->insert([
                'id'=>$customer['id'],
                'name'=>$customer['name'],
                'since'=>$customer['since'],
                'revenue'=>$customer['revenue']
            ]);
        }

    }
}
