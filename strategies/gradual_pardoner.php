<?php
// Gradual Pardoner:
// Retaliates against defections but gradually returns to cooperation if the opponent cooperates.
$strategies['gradual_pardoner'] = function ($data) {
    static $retaliation = false;

    if (empty($data)) {
        return MOVE_SPLIT; // Start by cooperating
    }

    $lastRound = end($data);
    
    if ($lastRound['opponent_move'] === MOVE_STEAL) {
        $retaliation = true; // Retaliate if the opponent stole
        return MOVE_STEAL; // Defect
    }

    if ($retaliation) {
        if ($lastRound['my_move'] === MOVE_SPLIT) {
            $retaliation = false; // Stop retaliating if I cooperated
        }
        return MOVE_STEAL; // Continue defecting
    }

    return MOVE_SPLIT; // Return to cooperation
};