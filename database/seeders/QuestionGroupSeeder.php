<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionGroupSeeder extends Seeder
{

    public function run(): void
    {
        $jsonFile = base_path('database/seeders/group.json');
        $jsonData = json_decode(File::get($jsonFile), true);

        DB::table('question_groups')->insert($jsonData);
    }
}
