<?php

namespace Database\Seeders;

use App\Models\DigitalObject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DigitalObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DigitalObject::factory()->count(10)->create();
    }
}
