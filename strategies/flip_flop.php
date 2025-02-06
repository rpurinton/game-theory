<?php
// Flip-Flop strategy:
// Alternate between cooperating and defecting on every round.
// On the first round, it cooperates (splits). Then it simply flips the previous move.
$strategies['flip_flop'] = function($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $lastRound = end($data);
    return ($lastRound['my_move'] === MOVE_SPLIT) ? MOVE_STEAL : MOVE_SPLIT;
};
?>