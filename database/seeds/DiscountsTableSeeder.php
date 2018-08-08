<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Discount;

class DiscountsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('discounts')->truncate();

        Discount::updateOrCreate([
            'discount_type' => '1',
            'discount_rules' => '[{"discount_amount": 10, "minimum_order_amount": 1000}]',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Discount::updateOrCreate([
            'discount_type' => '2',
            'discount_rules' => '[{"category_id": 2, "discount_products": 1, "minimum_order_products": 6}]',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Discount::updateOrCreate([
            'discount_type' => '3',
            'discount_rules' => '[{"category_id": 1, "discount_amount": 20, "minium_order_products": 2}]',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
