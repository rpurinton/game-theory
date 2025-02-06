<?php
// Reverse Tit-for-Tat:
// If no history, split.
// Otherwise, play the opposite of the opponent's previous move.
$strategies['reverse_tit'] = function ($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $lastRound = end($data);
    return ($lastRound['opponent_move'] === MOVE_SPLIT) ? MOVE_STEAL : MOVE_SPLIT;
};
