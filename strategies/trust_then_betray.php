<?php
// Trust Then Betray:
// Cooperate (split) for the first 10 rounds as a show of trust.
// After 10 rounds, always defect (steal) regardless of the opponent's behavior.
$strategies['trust_then_betray'] = function($data) {
    return (count($data) < 10) ? MOVE_SPLIT : MOVE_STEAL;
};
?>