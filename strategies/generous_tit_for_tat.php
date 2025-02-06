<?php
// Generous Tit-for-Tat:
// Starts cooperatively and forgives defections with a 70% chance of cooperation.
$strategies['generous_tit_for_tat'] = function ($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $lastRound = end($data);
    return (rand(0, 100) < 70 || $lastRound['opponent_move'] === MOVE_SPLIT) ? MOVE_SPLIT : MOVE_STEAL;
};