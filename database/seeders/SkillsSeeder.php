<?php

namespace Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class SkillsSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'skills';
        $this->filename = base_path() . '/database/seeders/csvs/skills.csv';
    }

    public function run()
    {
        parent::run();
    }
}
