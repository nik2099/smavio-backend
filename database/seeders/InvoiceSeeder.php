<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          Invoice::insert([
            [
                'user_id' => 'presentation',
                'status' => 1
            ]
        ]);
    }
}
