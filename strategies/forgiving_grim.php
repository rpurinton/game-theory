<?php
// Forgiving Grim Trigger:
// Initially cooperate. If the opponent defects at any point, defect (steal) until the opponent shows
// at least two consecutive rounds of cooperation, at which point forgive and return to cooperating.
$strategies['forgiving_grim'] = function($data) {
    // No history? Start co-operatively.
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    // If never defected, keep cooperating.
    $everDefected = false;
    foreach ($data as $round) {
        if ($round['opponent_move'] === MOVE_STEAL) {
            $everDefected = true;
            break;
        }
    }
    if (!$everDefected) {
        return MOVE_SPLIT;
    }
    // If there is history of defection, check if the last two rounds were cooperative.
    if (count($data) >= 2) {
        $lastTwo = array_slice($data, -2);
        if ($lastTwo[0]['opponent_move'] === MOVE_SPLIT && $lastTwo[1]['opponent_move'] === MOVE_SPLIT) {
            return MOVE_SPLIT;
        }
    }
    return MOVE_STEAL;
};
?>