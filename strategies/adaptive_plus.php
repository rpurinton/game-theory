<?php
// Adaptive Plus:
// Similar to the earlier adaptive strategy but over a longer window (up to 10 most recent rounds).
// If your average gain over these rounds trails your opponent’s by at least 0.5 per round, defect.
$strategies['adaptive_plus'] = function($data) {
    $rounds = count($data);
    if ($rounds < 2) return MOVE_SPLIT;
    $window = min(10, $rounds);
    $start = $rounds - $window;
    $myGain = 0;
    $oppGain = 0;
    // Calculate incremental gains over the window.
    for ($i = $start + 1; $i < $rounds; $i++) {
        $myGain += $data[$i]['my_score'] - $data[$i - 1]['my_score'];
        $oppGain += $data[$i]['opponent_score'] - $data[$i - 1]['opponent_score'];
    }
    $avgMy = $myGain / ($window - 1);
    $avgOpp = $oppGain / ($window - 1);
    if ($avgOpp > $avgMy + 0.5) {
        return MOVE_STEAL;
    }
    return end($data)['opponent_move'];
};
?>