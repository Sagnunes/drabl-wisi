<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * The list of roles to seed.
     */
    private const ROLE_LIST = [
        ['name' => 'Administrador', 'description' => 'Acesso total ao sistema'],
        ['name' => 'Coleção Digital', 'description' => 'Acesso a coleção digital']
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::ROLE_LIST)->chunk(100)->each(fn($chuck) => Role::factory()->createMany($chuck));
    }
}
