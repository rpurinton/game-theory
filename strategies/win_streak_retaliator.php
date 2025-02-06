<?php
// Win Streak Retaliator:
// If the opponent has defected in the last two rounds in a row, defect,
// otherwise mimic the opponent's most recent move.
$strategies['win_streak_retaliator'] = function($data) {
    if (empty($data)) return MOVE_SPLIT;
    if (count($data) >= 2) {
        $lastTwo = array_slice($data, -2);
        if ($lastTwo[0]['opponent_move'] === MOVE_STEAL &&
            $lastTwo[1]['opponent_move'] === MOVE_STEAL) {
            return MOVE_STEAL;
        }
    }
    return end($data)['opponent_move'];
};
?>