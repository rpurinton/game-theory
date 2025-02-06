<?php
// Consistent Mirroring:
// Primarily mirrors the opponent’s last move.
// However, if the opponent’s behavior has been highly inconsistent (switches more than half the rounds),
// the strategy defaults to cooperating.
$strategies['consistent_mirroring'] = function($data) {
    if (empty($data)) {
        return MOVE_SPLIT;
    }
    $switches = 0;
    $prev = null;
    foreach ($data as $round) {
        if ($prev !== null && $prev !== $round['opponent_move']) {
            $switches++;
        }
        $prev = $round['opponent_move'];
    }
    $total = count($data);
    // If the opponent switches moves in less than 50% of the rounds, mimic the last move.
    if ($switches / $total < 0.5) {
        return end($data)['opponent_move'];
    }
    // Otherwise, default to cooperation.
    return MOVE_SPLIT;
};
?>