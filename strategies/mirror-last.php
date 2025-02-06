<?php
// Mirror My Last Move:
// For the first round, split. After that, repeat whatever move you played in the previous round.
$strategies['mirror_last'] = function ($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $lastRound = end($data);
    return $lastRound['my_move'];
};
