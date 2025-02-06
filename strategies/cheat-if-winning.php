<?php
// Cheat If Winning:
// If you're currently ahead, steal to protect your lead.
// Otherwise, be nice and split.
$strategies['cheat_if_winning'] = function ($data) {
    $myScore = 0;
    $oppScore = 0;
    if (!empty($data)) {
        $lastRound = end($data);
        $myScore = $lastRound['my_score'];
        $oppScore = $lastRound['opponent_score'];
    }
    return ($myScore > $oppScore) ? MOVE_STEAL : MOVE_SPLIT;
};
