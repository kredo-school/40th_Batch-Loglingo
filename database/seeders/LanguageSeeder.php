<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{

    public function run(): void
    {
        $languages = [
            'English' => 'EN',
            'Japanese' => 'JP',
            'Spanish' => 'ES',
            'Chinese' => 'CN'
            ];

        foreach ($languages as $name => $code) {

            Language::firstOrCreate(
                ['name' => $name], 
                ['code' => $code]
                );
        }



    }

}
