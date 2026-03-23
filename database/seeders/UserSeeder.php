<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // get all the languages
        $allLanguages = Language::all();

        // check if its not empty
        if ($allLanguages->isEmpty()) {
            $this->command->error("Languages table is empty. Please run LanguageSeeder first.");
            return;
        }

        // 1. create admin
        $this->createAdminUsers($allLanguages);

        // 2. create 30 teachers
        for ($i = 1; $i <= 30; $i++) {
            // puck up 2 languages at random
            $langs = $allLanguages->random(2);

            User::firstOrCreate(
                ['email' => "teacher{$i}@gmail.com"],
                [
                    'name' => "Teacher {$i}",
                    'password' => Hash::make('password'),
                    'f_lang' => $langs[0]->id,
                    's_lang' => $langs[1]->id,
                    'role_id' => 3, // teacher
                ]
            );
        }

        // 3. create 50 students
        for ($i = 1; $i <= 50; $i++) {
            $langs = $allLanguages->random(2);

            User::firstOrCreate(
                ['email' => "user{$i}@gmail.com"],
                [
                    'name' => "Test User {$i}",
                    'password' => Hash::make('password'),
                    'f_lang' => $langs[0]->id,
                    's_lang' => $langs[1]->id,
                    'role_id' => 2, // user
                ]
            );
        }
    }

    private function createAdminUsers($languages)
    {
        // Admin
        for ($i = 1; $i <= 3; $i++) {
            User::firstOrCreate(
                ['email' => "admin{$i}@gmail.com"],
                [
                    'name' => "Admin {$i}",
                    'password' => Hash::make('password'),
                    'f_lang' => $languages->where('name', 'English')->first()->id ?? $languages->first()->id,
                    's_lang' => $languages->where('name', 'Japanese')->first()->id ?? $languages->last()->id,
                    'role_id' => 1,
                ]
            );
        }
    }
}
