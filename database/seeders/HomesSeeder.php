<?php

namespace Database\Seeders;

use App\Models\Homes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Homes::factory()
            ->count(300)
            ->create();
    }
}
