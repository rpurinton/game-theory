<?php
// Detective Strategy:
// Uses a probing sequence for the first four rounds and switches to tit-for-tat or always stealing based on the opponent's behavior.
$strategies['detective'] = function ($data) {
    $round = count($data);
    if ($round < 4) {
        return MOVE_SPLIT; // Probing phase: always cooperate
    }
    
    $lastRound = end($data);
    if ($lastRound['opponent_move'] === MOVE_STEAL) {
        return MOVE_STEAL; // Switch to always stealing if opponent defected
    }
    
    return $lastRound['opponent_move']; // Otherwise, mimic the opponent's last move
};