<?php
// Defensive Tit-for-Tat:
// Normally mimics the opponent’s last move,
// but if your current score is lagging behind the opponent's, switch to defection.
$strategies['defensive_tit_for_tat'] = function($data) {
    if (empty($data)) return MOVE_SPLIT;
    $last = end($data);
    return ($last['my_score'] < $last['opponent_score']) ? MOVE_STEAL : $last['opponent_move'];
};
?>