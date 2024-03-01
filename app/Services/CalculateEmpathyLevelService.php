<?php

namespace App\Services;

use App\Models\Answer;

class CalculateEmpathyLevelService
{
    public int $positiveResult = 0;
    public int $negativeeResult = 0;

    public function __construct()
    {
    }

    public function calculate()
    {
        $userId = auth()->id();

        $positiveScoredAnswers = Answer::where('user_id', $userId)->whereRelation('question', 'is_positive', true)->get();
        $negativeScoredAnswers = Answer::where('user_id', $userId)->whereRelation('question', 'is_positive', false)->get();

        foreach ($positiveScoredAnswers as $answer) {
            $this->positiveResult += intval($answer->answer);
        }

        foreach ($negativeScoredAnswers as $answer) {
            $this->negativeeResult += -intval($answer->answer);
        }

        return ($this->positiveResult + $this->negativeeResult);
    }

    public function getEmpathyLevel(string $gender)
    {
        $points = $this->calculate();

        if ($gender == 'female') {
            if ($points < 29) {
                return 'low';
            } elseif ($points >= 29 && $points < 59) {
                return 'average';
            } elseif ($points >= 59 && $points < 89) {
                return 'high';
            } elseif ($points >= 89) {
                return 'very high';
            }
        }

        if ($gender == 'male') {
            if ($points < 15) {
                return 'low';
            } elseif ($points >= 15 && $points < 31) {
                return 'average';
            } elseif ($points >= 31 && $points < 47) {
                return 'high';
            } elseif ($points >= 47) {
                return 'very high';
            }
        }
    }
}
