<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{

    public function run(): void
    {
        $languages = ['English', 'Japanese', 'Spanish' , 'Chinese'];

        foreach ($languages as $lang) {
            \App\Models\Language::firstOrCreate(['name' => $lang]);
        }
    }

}
