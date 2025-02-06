<?php
// main.php – run from the CLI

// Define our moves enum
define('MOVE_SPLIT', 'split');
define('MOVE_STEAL', 'steal');

// Number of tournaments and rounds per tournament
$tournamentsCount = 5;
$roundsCount = 200;

// Global strategies array – each strategy file will add its own function here.
$strategies = [];

// Load strategies from the "strategies" subfolder
$strategyFiles = glob(__DIR__ . '/strategies/*.php');
foreach ($strategyFiles as $file) {
    require_once $file;
}

// Check that we have at least one strategy available
if (empty($strategies)) {
    echo "No strategies loaded. Exiting...\n";
    exit(1);
}

// Store overall results: [ 'strategy' => total_points ]
$overallResults = [];
$strategyNames = array_keys($strategies);
foreach ($strategyNames as $name) {
    $overallResults[$name] = 0;
}

// Tournament head-to-head results: we will accumulate detailed results if desired.
$headToHeadResults = [];

// Run every strategy against every other strategy (including self match)
foreach ($strategyNames as $nameA) {
    foreach ($strategyNames as $nameB) {
        // For reporting a head-to-head match
        //echo "Matchup: $nameA vs $nameB\n";
        // Initialize aggregate scores for this pair over $tournamentsCount tournaments.
        $totalScoreA = 0;
        $totalScoreB = 0;
        for ($tournament = 1; $tournament <= $tournamentsCount; $tournament++) {
            // Initialize history and scores for each tournament match.
            $historyA = []; // History from perspective of player A
            $historyB = []; // History from perspective of player B
            $scoreA = 0;
            $scoreB = 0;
            // Run rounds
            for ($round = 1; $round <= $roundsCount; $round++) {
                // Each strategy decision is based ONLY on its own history.
                // It receives an array of rounds. For round i, each round is an associative array:
                // [ 'round' => <round number>, 'my_move' => <their move>, 'opponent_move' => <opponent move>, 'my_score' => <cumulative score>, 'opponent_score' => <opponent cumulative score> ]
                $moveA = call_user_func($strategies[$nameA], $historyA);
                $moveB = call_user_func($strategies[$nameB], $historyB);
                // Validate moves: they should be either MOVE_SPLIT or MOVE_STEAL
                if (!in_array($moveA, [MOVE_SPLIT, MOVE_STEAL])) {
                    die("Strategy '$nameA' returned invalid move '$moveA'. Defaulting to steal.\n");
                }
                if (!in_array($moveB, [MOVE_SPLIT, MOVE_STEAL])) {
                    die("Strategy '$nameB' returned invalid move '$moveB'. Defaulting to steal.\n");
                }
                // Compute outcome for this round
                if ($moveA === MOVE_SPLIT && $moveB === MOVE_SPLIT) {
                    $scoreA += 3;
                    $scoreB += 3;
                } elseif ($moveA === MOVE_SPLIT && $moveB === MOVE_STEAL) {
                    $scoreA += 0;
                    $scoreB += 5;
                } elseif ($moveA === MOVE_STEAL && $moveB === MOVE_SPLIT) {
                    $scoreA += 5;
                    $scoreB += 0;
                } elseif ($moveA === MOVE_STEAL && $moveB === MOVE_STEAL) {
                    $scoreA += 1;
                    $scoreB += 1;
                }
                // Append the round result to each player’s history.
                $historyA[] = [
                    'round' => $round,
                    'my_move' => $moveA,
                    'opponent_move' => $moveB,
                    'my_score' => $scoreA,
                    'opponent_score' => $scoreB,
                ];
                // For player B, swap the roles.
                $historyB[] = [
                    'round' => $round,
                    'my_move' => $moveB,
                    'opponent_move' => $moveA,
                    'my_score' => $scoreB,
                    'opponent_score' => $scoreA,
                ];
            } // end rounds
            //echo " Tournament $tournament result: $nameA scored $scoreA, $nameB scored $scoreB\n";
            $totalScoreA += $scoreA;
            $totalScoreB += $scoreB;
        } // end tournament

        echo "$nameA vs $nameB: $nameA total: $totalScoreA, $nameB total: $totalScoreB\n";
        // Add aggregate scores to overall results.
        $overallResults[$nameA] += $totalScoreA;
        $overallResults[$nameB] += $totalScoreB;
        // Optionally record head-to-head details.
        $headToHeadResults["$nameA vs $nameB"] = [
            'strategyA' => $nameA,
            'scoreA' => $totalScoreA,
            'strategyB' => $nameB,
            'scoreB' => $totalScoreB
        ];
    }
}

// Print overall results for each strategy.
echo "Overall Results:\n";
arsort($overallResults);
foreach ($overallResults as $strategyName => $score) {
    echo "  Strategy '$strategyName' total score: $score\n";
}
