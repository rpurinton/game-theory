<?php
// Calculated Revenge:
// Compares average points per round (my_score/round vs opponent_score/round).
// If the opponent's average is at least 1 point more than yours, defect to try to catch up;
// otherwise, mimic the opponent's most recent move.
$strategies['calculated_revenge'] = function($data) {
    if (empty($data)) return MOVE_SPLIT;
    $last = end($data);
    $round = $last['round'];
    $myAvg = $last['my_score'] / $round;
    $oppAvg = $last['opponent_score'] / $round;
    if (($oppAvg - $myAvg) >= 1.0) {
        return MOVE_STEAL;
    }
    return $last['opponent_move'];
};
?>