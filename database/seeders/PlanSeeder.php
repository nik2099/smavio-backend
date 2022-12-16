<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            'id' => 1,
	        'title' => 'Free',
	        'no_of_device' => 1,
	        'no_of_templates' => 1,
	        'no_of_campaigns' => 1,
	        'no_of_employees' => 1,
	        'tracking' => 'no',
	        'product_id' => 'no',
	        'pricing_id' => 'no',
	        'price' => 0,
        ]);
        DB::table('plans')->insert([
            'id' => 2,
            'title' => 'Essential',
            'no_of_device' => 5,
            'no_of_templates' => 5,
            'no_of_campaigns' => 3,
            'no_of_employees' => 3,
            'tracking' => 'no',
            'product_id' => 'prod_Kkv3EyI8hLLU7Y',
            'pricing_id' => 'price_1K5PDmDn36U1hb8Dh2aRyNQg',
            'price' => 9900
        ]);
        DB::table('plans')->insert([
            'id' => 3,
            'title' => 'Premium',
            'no_of_device' => 15,
            'no_of_templates' => 10,
            'no_of_campaigns' => 10,
            'no_of_employees' => 10,
            'tracking' => 'except_export',
            'product_id' => 'prod_Kkv4ZHW3YjDfTn',
            'pricing_id' => 'price_1K5PE7Dn36U1hb8DnRFLtalv',
            'price' => 14900
        ]);
        DB::table('plans')->insert([
            'id' => 4,
            'title' => 'Enterprise',
            'no_of_device' => 0,
            'no_of_templates' => 0,
            'no_of_campaigns' => 0,
            'no_of_employees' => 25,
            'tracking' => 'full',
            'product_id' => 'prod_Kkv3EyI8hLLU7Y',
            'pricing_id' => 'price_1K5PDmDn36U1hb8Dh2aRyNQg',
            'price' => 39900
        ]);
    }
}
