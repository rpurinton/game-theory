<?php
// Delayed Retaliation:
// Rather than reacting immediately, this strategy defects if the opponent defected two rounds ago.
$strategies['delayed_retaliation'] = function($data) {
    if (count($data) < 2) return MOVE_SPLIT;
    $twoRoundsAgo = $data[count($data) - 2]['opponent_move'];
    return ($twoRoundsAgo === MOVE_STEAL) ? MOVE_STEAL : MOVE_SPLIT;
};
?>