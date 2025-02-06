<?php
// Pavlov Strategy:
// Cooperates initially and then repeats the last move if the last round was a win, otherwise switches moves.
$strategies['pavlov'] = function ($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $lastRound = end($data);
    $myScore = $lastRound['my_score'];
    $opponentScore = $lastRound['opponent_score'];
    $outcome = ($myScore > $opponentScore) ? 'win' : 'lose';
    return ($outcome === 'win') ? $lastRound['my_move'] : (($lastRound['my_move'] === MOVE_SPLIT) ? MOVE_STEAL : MOVE_SPLIT);
};
