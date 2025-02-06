<?php
// Hard to Please:
// This strategy only cooperates if the opponent cooperated in the last two rounds; otherwise, it defects.
$strategies['hard_to_please'] = function ($data) {
    if (count($data) < 2) {
        return MOVE_STEAL; // Default to stealing if not enough data
    }
    $lastTwoRounds = array_slice($data, -2);
    if ($lastTwoRounds[0]['opponent_move'] === MOVE_SPLIT && $lastTwoRounds[1]['opponent_move'] === MOVE_SPLIT) {
        return MOVE_SPLIT;
    }
    return MOVE_STEAL;
};