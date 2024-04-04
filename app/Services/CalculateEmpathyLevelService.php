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
        // Get the ID of the authenticated user
        $userId = auth()->id();

        // Retrieve positive scored answers for the user
        $positiveScoredAnswers = Answer::where('user_id', $userId)->whereRelation('question', 'is_positive', true)->get();
        // Retrieve negative scored answers for the user
        $negativeScoredAnswers = Answer::where('user_id', $userId)->whereRelation('question', 'is_positive', false)->get();

        // Calculate positive and negative results
        foreach ($positiveScoredAnswers as $answer) {
            $this->positiveResult += intval($answer->answer);
        }

        foreach ($negativeScoredAnswers as $answer) {
            $this->negativeeResult += -intval($answer->answer);
        }

        // Return the addition result (points)
        return ($this->positiveResult + $this->negativeeResult);
    }

    public function getEmpathyLevel(string $gender)
    {
        // Calculate points based on answers
        $points = $this->calculate();

        // Determine empathy level based on gender and points
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
