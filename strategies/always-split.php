<?php
// Always Split strategy
// Always returns MOVE_SPLIT regardless of the history.
$strategies['always_split'] = function($data) {
    return MOVE_SPLIT;
};
