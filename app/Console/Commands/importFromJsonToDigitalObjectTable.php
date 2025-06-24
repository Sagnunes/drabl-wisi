<?php

namespace App\Console\Commands;

use App\Models\DigitalObject;
use App\Models\Fund;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class importFromJsonToDigitalObjectTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:digital-objects-import {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from a JSON file into the Digital Object table.';

    /**
     * Required fields that must exist in each JSON record
     *
     * @var array
     */
    protected array $requiredImageFields = ['img_name', 'img_thumbs', 'img_original'];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set memory limit for large imports
        ini_set('memory_limit', '1024M');

        $filename = $this->argument('filename');

        // Validate and parse the JSON file
        $jsonData = $this->validateAndParseJsonFile($filename);
        if (!$jsonData) {
            return 1; // Return error code
        }

        // Process the data
        $processedData = $this->processJsonData($jsonData);

        // Import the data
        $this->importData($processedData);

        return 0; // Success
    }

    /**
     * Validate and parse the JSON file
     *
     * @param string $filename The path to the JSON file
     * @return array|null The parsed JSON data or null if validation fails
     */
    protected function validateAndParseJsonFile(string $filename): ?array
    {
        // Validate file existence
        if (!Storage::exists($filename)) {
            $this->error("File not found: " . $filename);
            return null;
        }

        // Read file contents
        $contents = Storage::get($filename);

        // Validate JSON format
        if (!Str::isJson($contents)) {
            $this->error("Invalid JSON format: " . $filename);
            return null;
        }

        // Parse JSON
        $jsonData = json_decode($contents, true);

        // Validate JSON decoding
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("JSON parsing error: " . json_last_error_msg());
            return null;
        }

        return $jsonData;
    }

    /**
     * Process the JSON data into a format suitable for database insertion
     *
     * @param array $jsonData The parsed JSON data
     * @return array The processed data ready for insertion
     */
    protected function processJsonData(array $jsonData): array
    {
        // Preload funds for efficient mapping
        $funds = Fund::pluck('id', 'acronym')->all();

        $processedData = [];

        foreach ($jsonData as $row) {
            // Skip rows missing required fields
            if (!$this->validateRequiredFields($row)) {
                continue;
            }

            $processedData[] = [
                'fund_id' => $funds[$row['acronym']] ?? null,
                'title' => $row['title'] ?? null,
                'image_thumb' => $row['img_thumbs'],
                'image_derivative' => $row['img_original'],
                'image_name' => $row['img_name'],
                'inventory_number' => $row['inventory_number'] ?? null,
                'website_link' => $row['url'] ?? null,
                'status' => $row['status'] ?? null,
            ];
        }

        return $processedData;
    }

    /**
     * Validate that a row contains all required fields
     *
     * @param array $row The row to validate
     * @return bool Whether the row is valid
     */
    protected function validateRequiredFields(array $row): bool
    {
        if (count(array_diff($this->requiredImageFields, array_keys($row))) > 0) {
            $this->warn("Skipping row - missing required image fields");
            return false;
        }

        return true;
    }

    /**
     * Import the processed data into the database
     *
     * @param array $data The processed data to import
     * @return void
     */
    protected function importData(array $data): void
    {
        // Truncate the table before import
        //DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DigitalObject::truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Insert data in chunks to avoid memory issues
        DB::transaction(function () use ($data) {
            foreach (array_chunk($data, 1000) as $chunk) {
                DigitalObject::insert($chunk);
            }
        });

        $this->info("Successfully inserted " . count($data) . " records into digital_objects table");
    }
}
