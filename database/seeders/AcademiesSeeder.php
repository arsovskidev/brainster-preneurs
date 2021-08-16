<?php

namespace Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class AcademiesSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'academies';
        $this->filename = base_path() . '/database/seeders/csvs/academies.csv';
    }

    public function run()
    {
        parent::run();
    }
}
