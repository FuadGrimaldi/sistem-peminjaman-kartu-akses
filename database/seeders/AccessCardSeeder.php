<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 110; $i++) {
            $data[] = [
                'card_number' => 'AC' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => 'tersedia',
            ];
        }

        DB::table('access_cards')->insert($data);
    }
}
