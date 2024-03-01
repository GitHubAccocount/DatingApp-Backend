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
            ["text" => "It makes me sad to see a lonely stranger in a group"],
            ["text" => "People make too much of the feelings and sensitivity of animals."],
            ["text" => "I often find public displays of affection annoying"],
            ["text" => "I am annoyed by unhappy people who are just sorry for themselves"],
            ["text" => "I become nervous if others around me seem to be nervous"],
            ["text" => "I find it silly for people to cry out of happiness"],
            ["text" => "I tend to get emotionally involved with a friend's problems"],
            ["text" => "Sometimes the words of a love song can move me deeply"],
            ["text" => "I tend to lose control when I am bringing bad news to people"],
            ["text" => "The people around me have a great influence on my moods"],
            ["text" => "Most foreigners I have met seemed cool and unemotional"],
            ["text" => "I would rather be a social worker than work in a job training center"],
            ["text" => "I don't get upset just because a friend is acting upset"],
            ["text" => "I like to watch people open presents"],
            ["text" => "Lonely people are probably unfriendly"],
            ["text" => "Seeing people cry upsets me"],
            ["text" => "Some songs make me happy"],
            ["text" => "I really get involved with the feelings of the characters in a novel"],
            ["text" => "I get very angry when I see someone being ill-treated"],
            ["text" => "I am able to remain calm even though those around me worry"],
            ["text" => "When a friend starts to talk about his problems, I try to steer the conversation to something else"],
            ["text" => "Another's laughter is not catching for me"],
            ["text" => "Sometimes at the movies I am amused by the amount of crying and sniffling around me"],
            ["text" => "I am able to make decisions without being influenced by people's feelings"],
            ["text" => "I cannot continue to feel OK if people around me are depressed"],
            ["text" => "It is hard for me to see how some things upset people so much"],
            ["text" => "I am very upset when I see an animal in pain"],
            ["text" => "Becoming involved in books or movies is a little silly"],
            ["text" => "It upsets me to see helpless old people"],
            ["text" => "I become more irritated than sympathetic when I see someone's tears"],
            ["text" => "I become very involved when I watch a movie"],
            ["text" => "I often find that I can remain cool in spite of the excitement around me"],
            ["text" => "Little children sometimes cry for no apparent reason"]
        ];

        foreach ($questions as $question) {
            Question::create(['question' => $question['text']]);
        }
    }
}
