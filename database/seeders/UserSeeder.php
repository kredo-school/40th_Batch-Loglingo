<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $en = Language::where('name', 'English')->first();
        $jp = Language::where('name', 'Japanese')->first();
        $sp = Language::where('name', 'Spanish')->first();
        $cn = Language::where('name', 'Chinese')->first();

        User::firstOrCreate(
            ['email' => 'user1@gmail.com'], 
            [
                'name' => 'Taro Suzuki',
                'password' => Hash::make('password'),
                'f_lang' => $jp->id,
                's_lang' => $en->id,
                'role_id' => 2,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user2@gmail.com'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'f_lang' => $en->id,
                's_lang' => $jp->id,
                'role_id' => 2,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user3@gmail.com'],
            [
                'name' => 'Ivano Poletti',
                'password' => Hash::make('password'),
                'f_lang' => $sp->id,
                's_lang' => $en->id,
                'role_id' => 2,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user4@gmail.com'],
            [
                'name' => 'Jenna Cavill',
                'password' => Hash::make('password'),
                'f_lang' => $cn->id,
                's_lang' => $en->id,
                'role_id' => 2,
            ]
        );

        // teacher
        User::firstOrCreate(
            ['email' => 'teacher1@gmail.com'],
            [
                'name' => 'Jenna Cavill teacher1',
                'password' => Hash::make('password'),
                'f_lang' => $en->id,
                's_lang' => $jp->id,
                'role_id' => 3,
            ]
        );

        User::firstOrCreate(
            ['email' => 'teacher2@gmail.com'],
            [
                'name' => 'Jenna Cavill teacher2',
                'password' => Hash::make('password'),
                'f_lang' => $jp->id,
                's_lang' => $en->id,
                'role_id' => 3,
            ]
        );

        // admin
        User::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'admin1',
                'password' => Hash::make('password'),
                'f_lang' => $en->id,
                's_lang' => $jp->id,
                'role_id' => 1,
            ]
        );

    }
}
