<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\TemplateSeeder;
use Database\Seeders\CategorySeeder;
// use Database\Seeders\TemplateFieldSeeder;
use Database\Seeders\ConzeusTemplateFieldSeeder;
use Database\Seeders\DotupTemplateFieldSeeder;
use Database\Seeders\GutloopTemplateFieldSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
           CategorySeeder::class,
           PlanSeeder::class,
           TemplateSeeder::class,
           ConzeusTemplateFieldSeeder::class,
           DotupTemplateFieldSeeder::class,
           GutloopTemplateFieldSeeder::class,
           //TemplateFieldSeeder::class
        ]);
    }
}
