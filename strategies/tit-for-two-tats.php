<?php
// Tit-for-Two-Tats: Cooperate (split) until the opponent steals in two consecutive rounds.
// Otherwise, mimic split.
$strategies['tit_for_two_tats'] = function ($data) {
    $rounds = count($data);
    // In the first two rounds, just split.
    if ($rounds < 2) {
        return MOVE_SPLIT;
    }
    // Check if the opponent stole in the last two rounds.
    $lastOpponent1 = $data[$rounds - 1]['opponent_move'];
    $lastOpponent2 = $data[$rounds - 2]['opponent_move'];
    if ($lastOpponent1 === MOVE_STEAL && $lastOpponent2 === MOVE_STEAL) {
        return MOVE_STEAL;
    }
    return MOVE_SPLIT;
};
