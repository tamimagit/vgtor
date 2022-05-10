<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobileBankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('payment_methods')->where('name', '=', 'Mobile')->exists()) {
            DB::table('payment_methods')->insert([
                ['name' => 'Mobile', 'status' => 'Active']
            ]);
        }
    }
}
