<?php
// Opportunistic Conservative:
// Defects if the opponent's defection rate is 20% or more, otherwise cooperates.
$strategies['opportunistic_conservative'] = function ($data) {
    $defections = 0;
    $totalRounds = count($data);
    
    foreach ($data as $round) {
        if ($round['opponent_move'] === MOVE_STEAL) {
            $defections++;
        }
    }
    
    $defectionRate = $totalRounds > 0 ? $defections / $totalRounds : 0;
    
    return ($defectionRate >= 0.2) ? MOVE_STEAL : MOVE_SPLIT;
};