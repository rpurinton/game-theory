<?php
// Random strategy: chooses MOVE_SPLIT or MOVE_STEAL with equal probability.
$strategies['random'] = function($data) {
    return (rand(0, 1) === 1) ? MOVE_SPLIT : MOVE_STEAL;
};