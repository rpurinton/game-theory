<?php
// main.php – run from the CLI

// Define our move ENUM values
define('MOVE_SPLIT', 'split');
define('MOVE_STEAL', 'steal');

// Number of tournaments and rounds per tournament for each matchup
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

// Function to run a full round-robin tournament among the provided strategies.
// Returns an associative array of overall scores, with keys as strategy names.
function runTournament($activeStrategies, $tournamentsCount, $roundsCount)
{
    $strategyNames = array_keys($activeStrategies);
    // Initialize overall results for this tournament run.
    $overallResults = [];
    foreach ($strategyNames as $name) {
        $overallResults[$name] = 0;
    }

    // Run every strategy vs every other strategy (including self-match)
    foreach ($strategyNames as $nameA) {
        foreach ($strategyNames as $nameB) {
            //echo "Matchup: $nameA vs $nameB\n";

            $totalScoreA = 0;
            $totalScoreB = 0;

            // For each tournament
            for ($tournament = 1; $tournament <= $tournamentsCount; $tournament++) {
                // Reset histories and scores for each tournament
                $historyA = []; // history for player A perspective
                $historyB = []; // history for player B perspective
                $scoreA = 0;
                $scoreB = 0;

                // Run the rounds within one tournament
                for ($round = 1; $round <= $roundsCount; $round++) {
                    // Each strategy decides based solely on its history.
                    $moveA = call_user_func($activeStrategies[$nameA], $historyA);
                    $moveB = call_user_func($activeStrategies[$nameB], $historyB);

                    // Validate moves
                    if (!in_array($moveA, [MOVE_SPLIT, MOVE_STEAL])) {
                        die("Strategy '$nameA' returned invalid move '$moveA'. Defaulting to steal.");
                    }
                    if (!in_array($moveB, [MOVE_SPLIT, MOVE_STEAL])) {
                        die("Strategy '$nameB' returned invalid move '$moveB'. Defaulting to steal.");
                    }

                    // Evaluate the outcome for this round
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

                    // Record the round result for each strategy
                    $historyA[] = [
                        'round' => $round,
                        'my_move' => $moveA,
                        'opponent_move' => $moveB,
                        'my_score' => $scoreA,
                        'opponent_score' => $scoreB,
                    ];

                    $historyB[] = [
                        'round' => $round,
                        'my_move' => $moveB,
                        'opponent_move' => $moveA,
                        'my_score' => $scoreB,
                        'opponent_score' => $scoreA,
                    ];
                } // rounds loop

                //echo " Tournament $tournament result: $nameA scored $scoreA, $nameB scored $scoreB\n";
                $totalScoreA += $scoreA;
                $totalScoreB += $scoreB;
            } // tournaments loop

            echo "$nameA total: $totalScoreA, $nameB total: $totalScoreB\n";
            // Update overall results – note that each matchup contributes to both strategies' totals.
            $overallResults[$nameA] += $totalScoreA;
            $overallResults[$nameB] += $totalScoreB;
        }
    }

    // Display overall results for this elimination round.
    echo "Results for this elimination round:\n";
    arsort($overallResults);
    foreach ($overallResults as $strategyName => $score) {
        echo "  Strategy '$strategyName' total score: $score\n";
    }
    echo "\n";

    return $overallResults;
}

// Begin elimination rounds.
// Start with all loaded strategies.
$activeStrategies = $strategies;
$roundNumber = 1;

// Continue eliminating until only one strategy remains.
while (count($activeStrategies) > 1) {
    echo "=========================================\n";
    echo "Elimination Round: $roundNumber with " . count($activeStrategies) . " strategies\n";
    echo "=========================================\n\n";

    // Run the tournament for current set of strategies.
    $results = runTournament($activeStrategies, $tournamentsCount, $roundsCount);

    // Identify the strategy with the lowest score.
    $worstStrategy = null;
    $lowestScore = null;
    $allSameScore = true;
    $firstScore = reset($results);

    foreach ($results as $name => $score) {
        if ($lowestScore === null || $score < $lowestScore) {
            $lowestScore = $score;
            $worstStrategy = $name;
        }
        if ($score !== $firstScore) {
            $allSameScore = false;
        }
    }

    if ($allSameScore) {
        echo "All remaining strategies have the same score. Ending tournament.\n";
        break;
    }

    echo "Eliminating strategy: '$worstStrategy' with score: $lowestScore\n\n";

    // Remove the worst strategy from the active strategies.
    unset($activeStrategies[$worstStrategy]);

    $roundNumber++;
}

echo "=========================================\n";
echo "Final Remaining Strategies:\n";
foreach (array_keys($activeStrategies) as $strategyName) {
    echo "  $strategyName\n";
}
echo "=========================================\n";
