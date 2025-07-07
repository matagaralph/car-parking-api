<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Zone::create(['name' => 'Kwame Mall', 'price_per_hour' => 100]);
        Zone::create(['name' => 'Nketa Zone', 'price_per_hour' => 200]);
        Zone::create(['name' => 'Marondera P1', 'price_per_hour' => 300]);
    }
}
