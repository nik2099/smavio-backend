<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::insert([
            [
                'name' => 'dotup',
                'category_id' => 1
            ],
            [
                'name' => 'conzeus',
                'category_id' => 2
            ],
             [
                'name' => 'gutloop',
                'category_id' => 3
            ]
        ]);
    }
}
