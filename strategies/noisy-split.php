<?php
// Noisy Split: usually splits, but with a 10% chance it accidentally steals.
$strategies['noisy_split'] = function ($data) {
    // 10% chance to steal.
    if (rand(1, 100) <= 10) {
        return MOVE_STEAL;
    }
    return MOVE_SPLIT;
};
