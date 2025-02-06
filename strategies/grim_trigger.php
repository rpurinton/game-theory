<?php
// Grim Trigger strategy:
// Start by cooperating. If the opponent ever steals, then always steal for all subsequent rounds.
$strategies['grim_trigger'] = function ($data) {
    foreach ($data as $round) {
        if ($round['opponent_move'] === MOVE_STEAL) {
            return MOVE_STEAL;
        }
    }
    return MOVE_SPLIT;
};
