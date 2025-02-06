<?php
// Selfish Optimal:
// Based on the opponent's historical cooperation frequency, estimate expected gains.
// Expected gain if you split = p*3, if you steal = p*5 + (1-p)*1.
// Choose the move with the higher expected outcome.
$strategies['selfish_optimal'] = function($data) {
    if (empty($data)) return MOVE_SPLIT;
    $total = count($data);
    $coop = 0;
    foreach ($data as $round) {
        if ($round['opponent_move'] === MOVE_SPLIT) {
            $coop++;
        }
    }
    $p = $coop / $total;
    $expectedSplit = $p * 3;
    $expectedSteal = $p * 5 + (1 - $p) * 1;
    return ($expectedSteal > $expectedSplit) ? MOVE_STEAL : MOVE_SPLIT;
};
?>