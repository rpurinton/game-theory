<?php
// Aggressive Counter:
// Inspects the last three rounds, and if the opponent defected in at least two of them, defect;
// otherwise, cooperate.
$strategies['aggressive_counter'] = function($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $lastThree = array_slice($data, -3);
    $defections = 0;
    foreach ($lastThree as $round) {
        if ($round['opponent_move'] === MOVE_STEAL) {
            $defections++;
        }
    }
    return ($defections >= 2) ? MOVE_STEAL : MOVE_SPLIT;
};
?>