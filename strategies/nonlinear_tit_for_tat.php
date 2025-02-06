<?php
// Nonlinear Tit-for-Tat:
// Instead of a simple mimic, this strategy looks at the score differential.
// If the opponent is ahead by more than a threshold (e.g. 4 points), defect; otherwise cooperate.
$strategies['nonlinear_tit_for_tat'] = function($data) {
    if (empty($data)) return MOVE_SPLIT;
    $last = end($data);
    $diff = $last['opponent_score'] - $last['my_score'];
    return ($diff > 4) ? MOVE_STEAL : MOVE_SPLIT;
};
?>