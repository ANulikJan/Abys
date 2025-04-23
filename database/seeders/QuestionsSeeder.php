<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = base_path('database/seeders/questions.json');
        $jsonData = json_decode(File::get($jsonFile), true);

        foreach ($jsonData as $datum){
            DB::table('questions')->insert([
                "question" => $datum['question'],
                "uuid" => Str::random(),
                "score" => $datum['score'],
                "level" => $datum['level'],
                "order" => $datum['order'],
                "group_id" => $datum['group_id'],
                "sequence" => $datum['sequence']
            ]);

            foreach ($datum['answers'] as $answer){
                $answer['uuid'] = Str::random();
                DB::table('answers')->insert($answer);
            }
        }
    }
}
