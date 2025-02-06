<?php
// Tit-for-Tat strategy
// In the first round, it splits. For subsequent rounds,
// it mimics the opponent's previous move.
$strategies['tit_for_tat'] = function($data) {
    // If there is no history, return split.
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    // Get the last round's data.
    $lastRound = end($data);
    // Mimic opponent's move from the last round.
    return $lastRound['opponent_move'];
};
