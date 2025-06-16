<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class importFromJsonToDigitalObjectTable extends Command
{
    private string $file = 'archeevo.json';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-json-to-digital-object-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from a JSON file into the Digital Object table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '256M');

        $jsonData = Storage::json($this->file);

        $data = [];

        $funds = \App\Models\Fund::all();

        foreach ($jsonData as $row) {
            $data[] = [
                'fund_id' => $funds->firstWhere('acronym', $row['acronym'])->id ?? null,
                'title' => $row['title'],
                'image_thumb' => $row['img_thumbs'],
                'image_derivative' => $row['img_original'],
                'image_name' => $row['img_name'],
                'inventory_number' => $row['inventory_number'],
                'website_link' => $row['url'],
                'status' => $row['status'],
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            DB::table('digital_objects')->insert($chunk);
        }
    }
}
