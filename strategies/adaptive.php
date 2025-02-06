<?php
// Adaptive Strategy:
// This strategy evaluates the average score gain over the last 5 rounds and switches to stealing if its average gain falls behind the opponent's.
$strategies['adaptive'] = function ($data) {
    $lastRounds = array_slice($data, -5);
    $myScore = 0;
    $opponentScore = 0;

    foreach ($lastRounds as $round) {
        $myScore += $round['my_move'] === MOVE_SPLIT ? 1 : 0;
        $opponentScore += $round['opponent_move'] === MOVE_SPLIT ? 1 : 0;
    }

    $roundCount = count($lastRounds);
    if ($roundCount === 0) {
        return MOVE_SPLIT; // Default move if there are no rounds
    }

    $myAverage = $myScore / $roundCount;
    $opponentAverage = $opponentScore / $roundCount;

    return ($myAverage < $opponentAverage) ? MOVE_STEAL : MOVE_SPLIT;
};
