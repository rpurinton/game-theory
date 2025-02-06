<?php
// Switch on Loss:
// In the first round, split. In subsequent rounds, if you performed worse than your opponent in the previous round,
// switch your move; otherwise, keep the same move.
$strategies['switch_on_loss'] = function ($data) {
    $rounds = count($data);
    if ($rounds === 0) {
        return MOVE_SPLIT;
    }
    if ($rounds === 1) {
        // Only one round played: decide to switch if lost the first round.
        $firstRound = $data[0];
        if ($firstRound['my_score'] < $firstRound['opponent_score']) {
            return ($firstRound['my_move'] === MOVE_SPLIT) ? MOVE_STEAL : MOVE_SPLIT;
        }
        return $firstRound['my_move'];
    }
    // For rounds beyond the first, calculate the score gain during the last round.
    $prevRound = $data[$rounds - 2];
    $lastRound = $data[$rounds - 1];

    $myGain = $lastRound['my_score'] - $prevRound['my_score'];
    $oppGain = $lastRound['opponent_score'] - $prevRound['opponent_score'];

    if ($myGain < $oppGain) {
        // Switch move if lost the last round.
        return ($lastRound['my_move'] === MOVE_SPLIT) ? MOVE_STEAL : MOVE_SPLIT;
    }
    // Otherwise, keep the same move.
    return $lastRound['my_move'];
};
