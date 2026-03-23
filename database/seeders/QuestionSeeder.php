<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\User;
use App\Models\Language;

class QuestionSeeder extends Seeder
{

    public function run(): void
    {
        // 1.（role_id = 2）
        $students = User::where('role_id', 2)->get();
        $allLanguages = Language::all();

        if ($students->isEmpty() || $allLanguages->isEmpty()) {
            $this->command->error("Students or Languages are missing.");
            return;
        }

        // 2. 
        $questionSamples = [
            'English' => [
                'title' => 'Natural way to say this?',
                'content' => "I want to ask my boss for a day off tomorrow.\nRight now, I am thinking of saying, \"I want to rest tomorrow,\" but I am not sure if it sounds natural in English.\nI feel like it might sound a little too direct.\nIs there a more polite or natural way to say this in a workplace situation?\nIf possible, could you show me a few examples?\nI would also like to know which expression sounds the most professional.",
            ],

            'Japanese' => [
                'title' => '「お疲れ様」の使い分けについて',
                'content' => "仕事が終わった時に「お疲れ様です」と言うことがありますが、\n誰かが難しいことに挑戦した後にも同じように使えるのでしょうか。\n例えば、発表や試験が終わった人に対して言っても自然ですか?\nそれとも別の表現を使ったほうがいい場面がありますか?\nビジネスの場面と友達同士の会話で違いがあれば、それも知りたいです。\nできれば自然な例文もいくつか教えてください。",
            ],

            'Spanish' => [
                'title' => '¿Cuándo usar "Tú" y "Usted"?',
                'content' => "Todavía tengo dificultades para diferenciar entre el trato formal e informal en español.\nSé que \"tú\" se usa en contextos más casuales y \"usted\" en situaciones formales,\npero en la vida real no siempre sé cuál elegir.\nPor ejemplo, ¿qué debería usar con un profesor, un jefe o una persona mayor?\nTambién me gustaría saber si esto cambia según el país o la región.\nSi es posible, ¿podrían darme ejemplos naturales de cada caso?",
            ],

            'Chinese' => [
                'title' => '关于“了解”和“理解”的区别',
                'content' => "我学习中文的时候，常常看到“了解”和“理解”这两个词。\n我知道它们都有 to understand 的意思，\n可是我不太清楚在实际会话中应该怎么区分。\n比如,了解一个人、了解情况、理解别人的心情,这些搭配有什么规律吗？\n它们在口语和书面语里有没有不同的感觉?\n如果可以的话,请给我一些简单又自然的例句，谢谢。",
            ],
        ];

        // 3. generate 100 questions
        for ($i = 1; $i <= 250; $i++) {
            $user = $students->random();

            // --- 50% learning language
            $isAdvanced = (rand(1, 10) <= 5);
            $writingLangId = $isAdvanced ? $user->s_lang : $user->f_lang;

            // choose content
            $writingLang = $allLanguages->find($writingLangId);
            $sample = $questionSamples[$writingLang->name ?? 'English'] ?? $questionSamples['English'];

            // generate question
            $question = Question::create([
                'user_id' => $user->id,
                'written_lang' => $writingLangId, // 50%f_lang、50%でs_lang
                'q_title' => $sample['title'] . ($isAdvanced ? " (Advanced)" : "") . " #{$i}",
                'q_content' => $sample['content'],
            ]);

            // --- target language
            // basically by s_lang
            // rarely use the 3rd language
            $targetLangId = (rand(1, 10) <= 8) ? $user->s_lang : $allLanguages->random()->id;

            $question->tags()->attach($targetLangId);
        }

        $this->command->info("QuestionSeeder: 25 hybrid questions created successfully.");
    }
}
