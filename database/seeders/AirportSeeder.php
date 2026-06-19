<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/airports.csv');

        if (!file_exists($file)) {
            throw new \Exception("airports.csv not found in storage/app");
        }

        $handle = fopen($file, 'r');

        $header = fgetcsv($handle);

        $buffer = [];
        $now = now();

        while (($row = fgetcsv($handle)) !== false) {

            $data = array_combine($header, $row);

            $iata = strtoupper(trim($data['iata_code'] ?? ''));

            // 🔥 ONLY AIRPORTS WITH IATA
            if (empty($iata)) {
                continue;
            }

            // OPTIONAL: basic validation
            if (!preg_match('/^[A-Z]{3}$/', $iata)) {
                continue;
            }

            $buffer[] = [
                'iata' => $iata,
                'icao' => $data['icao_code'] ?? null,
                'name' => $data['name'] ?? null,
                'city' => $data['municipality'] ?? null,
                'country' => $data['iso_country'] ?? null,
                'latitude' => $data['latitude_deg'] ?? null,
                'longitude' => $data['longitude_deg'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // 🔥 batch insert (performance)
            if (count($buffer) === 1000) {
                DB::table('airports')->insert($buffer);
                $buffer = [];
            }
        }

        fclose($handle);

        // flush remaining
        if (!empty($buffer)) {
            DB::table('airports')->insert($buffer);
        }
    }
}
