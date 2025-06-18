<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     *  a list of status to seed
     */
    private const STATUS_LIST = [
        ['name' => 'Pendente', 'description' => 'À espera de revisão ou aprovação'],
        ['name' => 'Ativo', 'description' => 'Pedido foi aceite'],
        ['name' => 'Suspenso', 'description' => 'Acesso está temporariamente desativado'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::STATUS_LIST)->chunk(100)->each(fn($chuck) => Status::factory()->createMany($chuck));
    }
}
