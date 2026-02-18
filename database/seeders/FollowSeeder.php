<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // 自分以外のユーザーからランダムに2人選ぶ
            $others = $users->where('id', '!=', $user->id)->random(
                min(2, $users->count() - 1)
            );

            foreach ($others as $other) {
                // フォロー関係を作成（重複防止）
                $user->followings()->syncWithoutDetaching($other->id);
            }
        }
    }
}
