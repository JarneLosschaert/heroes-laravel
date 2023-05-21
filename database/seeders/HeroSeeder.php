<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hero;

class HeroSeeder extends Seeder
{
    
    public function run(): void
    {
        $file = fopen('database/seeders/data/heros.csv', 'r');
        $header = fgetcsv($file);
        $data = [];
        while ($row = fgetcsv($file)) {
            $data[] = array_combine($header, $row);
        }

        fclose($file);
        
        $model = new Hero();
        foreach($data as $row) {
            $model->create($row);        
        }
    }
}
