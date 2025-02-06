<?php
// Score Based strategy:
// If your current score is lower than the opponent's, try stealing to catch up.
// Otherwise, split.
$strategies['score_based'] = function ($data) {
    $currentScore = 0;
    $oppScore = 0;
    if (!empty($data)) {
        $lastRound = end($data);
        $currentScore = $lastRound['my_score'];
        $oppScore = $lastRound['opponent_score'];
    }
    return ($currentScore < $oppScore) ? MOVE_STEAL : MOVE_SPLIT;
};
