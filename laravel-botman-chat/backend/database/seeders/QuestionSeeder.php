<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $file = storage_path('app/questions.csv');
        
        if (!file_exists($file) || !is_readable($file)) {
            throw new \Exception("CSV file not found or not readable.");
        }

        $data = array_map('str_getcsv', file($file));
        $header = array_shift($data); // assumes first row is headers: question,response

        foreach ($data as $row) {
            $row = array_combine($header, $row);
            Question::create([
                'question' => $row['question'],
                'response' => $row['response'],
            ]);
        }
    }
}
