<?php
// Emotional:
// Reacts strongly to recent negative outcomes. If the opponent defected during the last two rounds,
// then defect. Otherwise, if the opponent cooperated in the most recent round, cooperate; if not, choose randomly.
$strategies['emotional'] = function($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    if (count($data) >= 2) {
        $lastTwo = array_slice($data, -2);
        if ($lastTwo[0]['opponent_move'] === MOVE_STEAL && $lastTwo[1]['opponent_move'] === MOVE_STEAL) {
            return MOVE_STEAL;
        }
    }
    $lastRound = end($data);
    if ($lastRound['opponent_move'] === MOVE_SPLIT) {
        return MOVE_SPLIT;
    }
    return (rand(0, 1) === 1) ? MOVE_SPLIT : MOVE_STEAL;
};
?>