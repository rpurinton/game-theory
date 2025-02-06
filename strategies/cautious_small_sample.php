<?php
// Cautious Small Sample:
// Focuses on the opponent's behavior over the last 5 rounds.
// If the opponent cooperated in at least 3 out of 5 rounds, then cooperate; otherwise, defect.
$strategies['cautious_small_sample'] = function($data) {
    if (count($data) < 5) {
        return MOVE_SPLIT;
    }
    $lastFive = array_slice($data, -5);
    $coopCount = 0;
    foreach ($lastFive as $round) {
        if ($round['opponent_move'] === MOVE_SPLIT) {
            $coopCount++;
        }
    }
    return ($coopCount >= 3) ? MOVE_SPLIT : MOVE_STEAL;
};
?>