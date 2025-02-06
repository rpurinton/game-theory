<?php
// Suspicious Tit-for-Tat:
// Starts by defecting and then mimics the opponent's moves thereafter.
$strategies['suspicious_tit_for_tat'] = function ($data) {
    if (empty($data)) {
        return MOVE_STEAL;
    }
    $lastRound = end($data);
    return $lastRound['opponent_move'];
};