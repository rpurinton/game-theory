<?php
// Always Steal strategy
// Always returns MOVE_STEAL regardless of the history.
$strategies['always_steal'] = function($data) {
    return MOVE_STEAL;
};
