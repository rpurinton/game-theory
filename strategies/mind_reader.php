<?php
// Mind Reader Strategy:
// Cooperates if the opponent has cooperated as often as they have defected, otherwise defects.
$strategies['mind_reader'] = function ($data) {
    $cooperations = 0;
    $defections = 0;

    foreach ($data as $round) {
        if ($round['opponent_move'] === MOVE_SPLIT) {
            $cooperations++;
        } else {
            $defections++;
        }
    }

    return ($cooperations >= $defections) ? MOVE_SPLIT : MOVE_STEAL;
};