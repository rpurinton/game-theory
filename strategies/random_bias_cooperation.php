<?php
// Random Bias Cooperation:
// Chooses randomly between splitting and stealing, but biases the probability based on the opponent's overall cooperativeness.
// If the opponent’s cooperation rate (over rounds played) is greater than 50%, then cooperate 80% of the time; otherwise, only 40%.
$strategies['random_bias_cooperation'] = function($data) {
    $total = count($data);
    if ($total === 0) {
        return MOVE_SPLIT;
    }
    $coopCount = 0;
    foreach ($data as $round) {
        if ($round['opponent_move'] === MOVE_SPLIT) {
            $coopCount++;
        }
    }
    $coopRate = $coopCount / $total;
    $chance = ($coopRate > 0.5) ? 80 : 40;
    return (rand(1, 100) <= $chance) ? MOVE_SPLIT : MOVE_STEAL;
};
?>