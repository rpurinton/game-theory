<?php
// Weighted Tit-for-Tat:
// Looks at the last up-to-5 rounds giving later rounds more weight.
// If the weighted rate of opponent cooperation is ≥ 60%, cooperate; otherwise, defect.
$strategies['weighted_tit_for_tat'] = function($data) {
    if (empty($data)) return MOVE_SPLIT;
    $n = count($data);
    $window = min(5, $n);
    $weightSum = 0;
    $coopWeight = 0;
    // Use increasing weights for more recent rounds.
    for ($i = $n - $window; $i < $n; $i++) {
        $weight = ($i - ($n - $window) + 1);
        $weightSum += $weight;
        if ($data[$i]['opponent_move'] === MOVE_SPLIT) {
            $coopWeight += $weight;
        }
    }
    $weightedRate = $coopWeight / $weightSum;
    return ($weightedRate >= 0.6) ? MOVE_SPLIT : MOVE_STEAL;
};
?>