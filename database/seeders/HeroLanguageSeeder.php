<?php

namespace Database\Seeders;

use App\Models\HeroLanguage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen('app/data/csv/herosLanguage.csv', 'r');
        $header = fgetcsv($file);
        $data = [];
        while ($row = fgetcsv($file)) {
            $data[] = array_combine($header, $row);
        }

        fclose($file);
        
        $model = new HeroLanguage();
        foreach($data as $row) {
            $model->create($row);        
        }
    }
}
