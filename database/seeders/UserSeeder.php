<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'status_id' => UserStatusEnum::APPROVED
        ]);

        $user->roles()->attach(1);
    }
}
