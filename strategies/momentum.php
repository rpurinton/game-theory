<?php
// Momentum:
// Looks at the most recent round's payoff. If it was high (i.e. a good result), keep the same move;
// if the payoff was lower than expected (indicating a loss), then flip the last move.
$strategies['momentum'] = function($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $rounds = count($data);
    $last = end($data);
    $prevScore = ($rounds > 1) ? $data[$rounds - 2]['my_score'] : 0;
    $gain = $last['my_score'] - $prevScore;
    // A gain of 3 or 5 is considered acceptable.
    if ($gain >= 3) {
        return $last['my_move'];
    } else {
        return ($last['my_move'] === MOVE_SPLIT) ? MOVE_STEAL : MOVE_SPLIT;
    }
};
?>