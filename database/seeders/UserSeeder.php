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

        // 1. 既存の重要ユーザー（AdminやTeacher）を先に作成
        $this->createFixedUsers($en, $jp);

        // 2. 通報テスト用に、一般ユーザーをさらに20人ほど作成
        for ($i = 1; $i <= 20; $i++) {
            User::firstOrCreate(
                ['email' => "user{$i}@gmail.com"],
                [
                    'name' => "Test User {$i}",
                    'password' => Hash::make('password'),
                    'f_lang' => $en->id,
                    's_lang' => $jp->id,
                    'role_id' => 2, // 一般ユーザー
                ]
            );
        }
    }

    private function createFixedUsers($en, $jp)
    {
        // 管理者
        User::firstOrCreate(['email' => 'admin1@gmail.com'], [
            'name' => 'admin1',
            'password' => Hash::make('password'),
            'f_lang' => $en->id,
            's_lang' => $jp->id,
            'role_id' => 1,
        ]);

        User::firstOrCreate(['email' => 'admin2@gmail.com'], [
            'name' => 'admin2',
            'password' => Hash::make('password'),
            'f_lang' => $en->id,
            's_lang' => $jp->id,
            'role_id' => 1,
        ]);

        User::firstOrCreate(['email' => 'admin3@gmail.com'], [
            'name' => 'admin3',
            'password' => Hash::make('password'),
            'f_lang' => $en->id,
            's_lang' => $jp->id,
            'role_id' => 1,
        ]);


        // 先生
        User::firstOrCreate(['email' => 'teacher1@gmail.com'], [
            'name' => 'Teacher 1',
            'password' => Hash::make('password'),
            'f_lang' => $en->id,
            's_lang' => $jp->id,
            'role_id' => 3,
        ]);

        User::firstOrCreate(['email' => 'teacher2@gmail.com'], [
            'name' => 'Teacher 2',
            'password' => Hash::make('password'),
            'f_lang' => $en->id,
            's_lang' => $jp->id,
            'role_id' => 3,
        ]);

        User::firstOrCreate(['email' => 'teacher3@gmail.com'], [
            'name' => 'Teacher 3',
            'password' => Hash::make('password'),
            'f_lang' => $en->id,
            's_lang' => $jp->id,
            'role_id' => 3,
        ]);
    }
}
