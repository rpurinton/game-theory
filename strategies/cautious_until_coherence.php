<?php
// Cautious Until Coherence:
// Waits to see a consistent cooperative pattern from the opponent.
// If in the last three rounds at least two were cooperative, then cooperate; otherwise, defect.
$strategies['cautious_until_coherence'] = function($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    if (count($data) >= 3) {
        $lastThree = array_slice($data, -3);
        $coopCount = 0;
        foreach ($lastThree as $round) {
            if ($round['opponent_move'] === MOVE_SPLIT) {
                $coopCount++;
            }
        }
        if ($coopCount >= 2) {
            return MOVE_SPLIT;
        }
    }
    return MOVE_STEAL;
};
?>