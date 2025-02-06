<?php
// Random Then Tit-for-Tat:
// In the first round, choose a random move. Afterwards, follow a tit-for-tat approach.
$strategies['random_then_tit_for_tat'] = function ($data) {
    if (empty($data)) {
        return (rand(0, 1) === 1) ? MOVE_SPLIT : MOVE_STEAL;
    }
    $lastRound = end($data);
    return $lastRound['opponent_move'];
};
