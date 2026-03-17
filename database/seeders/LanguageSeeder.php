<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Language::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $languages = [
            [
                'name' => 'English',
                'code' => 'EN',
                'color' => 'blue',
                'status' => true,
            ],
            [
                'name' => 'Japanese',
                'code' => 'JP',
                'color' => 'red',
                'status' => true,
            ],
            [
                'name' => 'Spanish',
                'code' => 'ES',
                'color' => 'yellow',
                'status' => true,
            ],
            [
                'name' => 'Chinese',
                'code' => 'CN',
                'color' => 'orange',
                'status' => true,
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
