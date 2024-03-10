<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ["text" => "It makes me sad to see a lonely stranger in a group", "is_positive" => 1],
            ["text" => "People make too much of the feelings and sensitivity of animals.", "is_positive" => 0],
            ["text" => "I often find public displays of affection annoying", "is_positive" => 0],
            ["text" => "I am annoyed by unhappy people who are just sorry for themselves", "is_positive" => 0],
            ["text" => "I become nervous if others around me seem to be nervous", "is_positive" => 1],
            ["text" => "I find it silly for people to cry out of happiness", "is_positive" => 0],
            ["text" => "I tend to get emotionally involved with a friend's problems", "is_positive" => 1],
            ["text" => "Sometimes the words of a love song can move me deeply", "is_positive" => 1],
            ["text" => "I tend to lose control when I am bringing bad news to people", "is_positive" => 1],
            ["text" => "The people around me have a great influence on my moods", "is_positive" => 1],
            ["text" => "Most foreigners I have met seemed cool and unemotional", "is_positive" => 0],
            ["text" => "I would rather be a social worker than work in a job training center", "is_positive" => 1],
            ["text" => "I don't get upset just because a friend is acting upset", "is_positive" => 0],
            ["text" => "I like to watch people open presents", "is_positive" => 1],
            ["text" => "Lonely people are probably unfriendly", "is_positive" => 0],
            ["text" => "Seeing people cry upsets me", "is_positive" => 1],
            ["text" => "Some songs make me happy", "is_positive" => 1],
            ["text" => "I really get involved with the feelings of the characters in a novel", "is_positive" => 1],
            ["text" => "I get very angry when I see someone being ill-treated", "is_positive" => 1],
            ["text" => "I am able to remain calm even though those around me worry", "is_positive" => 0],
            ["text" => "When a friend starts to talk about his problems, I try to steer the conversation to something else", "is_positive" => 0],
            ["text" => "Another's laughter is not catching for me", "is_positive" => 0],
            ["text" => "Sometimes at the movies I am amused by the amount of crying and sniffling around me", "is_positive" => 0],
            ["text" => "I am able to make decisions without being influenced by people's feelings", "is_positive" => 0],
            ["text" => "I cannot continue to feel OK if people around me are depressed", "is_positive" => 1],
            ["text" => "It is hard for me to see how some things upset people so much", "is_positive" => 0],
            ["text" => "I am very upset when I see an animal in pain", "is_positive" => 1],
            ["text" => "Becoming involved in books or movies is a little silly", "is_positive" => 0],
            ["text" => "It upsets me to see helpless old people", "is_positive" => 1],
            ["text" => "I become more irritated than sympathetic when I see someone's tears", "is_positive" => 0],
            ["text" => "I become very involved when I watch a movie", "is_positive" => 1],
            ["text" => "I often find that I can remain cool in spite of the excitement around me", "is_positive" => 0],
            ["text" => "Little children sometimes cry for no apparent reason", "is_positive" => 0]
        ];

        foreach ($questions as $question) {
            Question::create([
                'question' => $question['text'],
                'is_positive' => $question['is_positive'],
            ]);
        }
    }
}
