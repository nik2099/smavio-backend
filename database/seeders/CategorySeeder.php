<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'name' => 'vergleich',
                'status' => 1
            ],
            [
                'name' => 'prasentation',
                'status' => 1
            ],
            [
                 'name' => 'umfrage',
                 'status' => 1
            ]
        ]);
    }
}
