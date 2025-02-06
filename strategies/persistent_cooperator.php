<?php
// Persistent Cooperator:
// For the early phase (first ~100 rounds) always cooperate.
// Later, start mimicking the opponent’s last move.
$strategies['persistent_cooperator'] = function($data) {
    if (count($data) < 100) {
        return MOVE_SPLIT;
    }
    return end($data)['opponent_move'];
};
?>