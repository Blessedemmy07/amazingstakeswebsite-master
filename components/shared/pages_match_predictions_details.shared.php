<?php
require_once __DIR__ . '/../functions/determine_winning_team_and_odd.php';
require_once __DIR__ . '/../functions/determine_probability_results.php';
require_once __DIR__ . '/../functions/determine_live_scores.php';
require_once __DIR__ . '/../functions/ComputefixtureAverage.php';
require_once __DIR__ . '/../functions/double_chance_winning_team_and_odd.php';
require_once __DIR__ . '/../functions/double_chance_probability_results.php';
include_once __DIR__ . "/../functions/getDeviceType.php";
// require_once 'functions/under_over_winning_team_and_odd.php';
// require_once 'functions/under_over_probability_results.php';
// require_once 'functions/BothTeamsToScore.php';
// require_once 'functions/halftime_winning_team_and_odd.php';
// require_once 'functions/halftime_probability_results.php';

// Simulating useEffect for initial batch loading

function firstBatch($url, $headers) {
    $endpointStatus = [];
    $gamesFixtures = [];

    $data = getAllData($url, 0, 20, headers: $headers);

    if ($data['status'] === true) {
        $endpointStatus = $data['message'];

        $gamesFixtures = $data['data'];

        if (strpos($_SERVER['REQUEST_URI'], "sportpesa-mega-jackpot-prediction") === false &&  
            strpos($_SERVER['REQUEST_URI'], "sportpesa-midweek-jackpot-predictions") === false) {
            
            // If length of first batch reached 20, then run next batch
            if (count($data['data']) > 20) {
                fetchNextBatch($url, $endpointStatus, $gamesFixtures, $headers);
            }
        }              

        return $gamesFixtures;

    } else {
        $endpointStatus = $data['message'];
        
        $gamesFixtures = $data['data'];
    }
}

// Function to fetch next batch of fixtures
function fetchNextBatch($url, &$endpointStatus, &$gamesFixtures, $headers) {
    $data = getAllData($url, 0, 1200, $headers);

    if ($data['status'] === true) {
        $endpointStatus = $data['message'];

        $gamesFixtures = $data['data'];

        return $gamesFixtures;
        
    } else {
        $endpointStatus = $data['message'];
    }
}

// Function to fetch all data based on URL and indices
function getAllData($url, $startIndex, $endIndex, $headers) {
    $urlWithParams = "";

    // Adjust the URL according to route
    if (strpos($_SERVER['REQUEST_URI'], "league/[country-name]/[football-prediction-for-league]") !== false || 
              strpos($_SERVER['REQUEST_URI'], "country/[football-prediction-for-country]") !== false) {
        $urlWithParams = $url;

    }  elseif (strpos($_SERVER['REQUEST_URI'], "sportpesa-mega-jackpot-prediction") !== false || 
        strpos($_SERVER['REQUEST_URI'], "sportpesa-midweek-jackpot-predictions") !== false) {

        $urlWithParams = $url;

    } else {

        $urlWithParams = $url . "&start_index=" . $startIndex . "&end_index=" . $endIndex;
    }

    try {
        $options = [
            'http' => [
                'header' => "Authorization: {$headers['Authorization']}", // Pass the header as a string
                'method' => 'GET',
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($urlWithParams, false, $context);

        return json_decode($response, true);

    } catch (Exception $e) {
        // Handle error here
        return ['status' => false, 'message' => 'Error fetching data.'];
    }
}

function getMatchPredictionDetails($url, $headers) {
    $isMobile = false;
    $endpointStatus = "";
    $gamesFixtures = []; // Array to hold fixtures
    $predictionsList = [];
    $liveUpdateCounter = 0;
    $sharedTableDetailsArray = [];
      
    $deviceType = getDeviceType();

    // Call the function to get match prediction details
    $gamesFixtures = firstBatch($url, $headers);
    
    if (is_array($gamesFixtures) || $gamesFixtures instanceof Countable) {
        if (count($gamesFixtures) > 0) {
            foreach ($gamesFixtures as $index => $fixture) {
                $winningTeam = "";
                
                // Decode halftime data stored as JSON in MySQL
                $scoresData = json_decode($fixture['scores'], true);

                // return $scoresData;
                $halftimeData = "";
                $extratimeData = "";
                $penaltyData = "";

                $home_odd = isset($fixture['percent_pred_home']) && $fixture['percent_pred_home'] !== null 
                ? intval(substr($fixture['percent_pred_home'], 0, -1)) 
                : "-";

                $draw_odd = isset($fixture['percent_pred_draw']) && $fixture['percent_pred_draw'] !== null 
                ? intval(substr($fixture['percent_pred_draw'], 0, -1)) 
                : "-";

                $away_odd = isset($fixture['percent_pred_away']) && $fixture['percent_pred_away'] !== null 
                ? intval(substr($fixture['percent_pred_away'], 0, -1)) 
                : "-";


                $fixturesAverage = computeFixtureAverage($fixture['teams_perfomance_home_for'],$fixture['teams_perfomance_home_aganist'],$fixture['teams_perfomance_away_for'],$fixture['teams_perfomance_away_aganist'],$fixture['teams_games_played_home'],$fixture['teams_games_played_away']);
                
                $path = substr($_SERVER['REQUEST_URI'], 1);

                if (strpos($path, "double-chance-predictions") !== false) {
                    $computed_winning_preds = DoubleChanceWinningTeamAndOdd($home_odd, $draw_odd, $away_odd, $fixture, $path);

                    $winning_team = $computed_winning_preds[0];
                    $winning_odd = $computed_winning_preds[1];

                    $probability_results = DoubleChanceProbabilityResults($fixture, $winning_team, $path);

                } elseif (strpos($path, "predictions-under-over") !== false) {
                    $computed_winning_preds = UnderOverWinningTeamAndOdd($fixturesAverage, $isMobile);

                    $winning_team = $computed_winning_preds[0];
                    $winning_odd = $computed_winning_preds[1];

                    $probability_results = UnderOverProbabilityResults($fixture, $winning_team);

                } elseif (strpos($path, "predictions-both-to-score") !== false) {
                    $probability_results = BothTeamsToScore($fixture);

                }
                //  elseif (strpos($path, "predictions-halftime-fulltime") !== false) {
                //     $ht_computed_winning_preds = HalfTimeWinningTeamAndOdd($ht_home_odd, $ht_draw_odd, $ht_away_odd, $fixture);

                //     $ht_winning_team = $ht_computed_winning_preds[0];
                //     $ht_winning_odd = $ht_computed_winning_preds[1];

                //     $ht_probability_results = HalfTimeProbabilityResults($fixture, $ht_winning_team);

                //     $computed_winning_preds = WinningTeamAndOdd($home_odd, $draw_odd, $away_odd, $fixture);

                //     $winning_team = $computed_winning_preds[0];
                //     $winning_odd = $computed_winning_preds[1];

                //     $probability_results = ProbabilityResults($fixture, $winning_team);

                // }
                else {
                    $computed_winning_preds = WinningTeamAndOdd($home_odd, $draw_odd, $away_odd, $fixture);

                    $winning_team = $computed_winning_preds[0];
                    $winning_odd = $computed_winning_preds[1];

                    $probability_results = ProbabilityResults($fixture, $winning_team);
                }


                if ($fixture['scores'] != null) {
                    if (isset($scoresData['halftime'])) {
                        if (isset($scoresData['halftime']['home'])) {
                            $halftimeData = '(' . $scoresData['halftime']['home'] . ' - ' . $scoresData['halftime']['away'] . ')';
                        }
                        if (isset($scoresData['extratime']['home'])) {
                            $extratimeData = $scoresData['extratime']['home'] . ' - ' . $scoresData['extratime']['away'];
                        }
                        if (isset($scoresData['penalty']['home'])) {
                            $penaltyData = $scoresData['penalty']['home'] . ' - ' . $scoresData['penalty']['away'];
                        }
                    }
                }

            // Initialize odds
                $homeOdd = isset($fixture['percent_pred_home']) ? intval(rtrim($fixture['percent_pred_home'], '%')) : "-";
                $drawOdd = isset($fixture['percent_pred_draw']) ? intval(rtrim($fixture['percent_pred_draw'], '%')) : "-";
                $awayOdd = isset($fixture['percent_pred_away']) ? intval(rtrim($fixture['percent_pred_away'], '%')) : "-";

            // Additional odds for halftime/fulltime predictions
                if (strpos($_SERVER['REQUEST_URI'], "predictions-halftime-fulltime") !== false) {
                    $htHomeOdd = isset($fixture['hf_percent_pred_home']) ? intval(rtrim($fixture['hf_percent_pred_home'], '%')) : "-";
                    $htDrawOdd = isset($fixture['hf_percent_pred_draw']) ? intval(rtrim($fixture['hf_percent_pred_draw'], '%')) : "-";
                    $htAwayOdd = isset($fixture['hf_percent_pred_away']) ? intval(rtrim($fixture['hf_percent_pred_away'], '%')) : "-";
                }

                // Live scores logic (assumed)
                $liveScoresResults = determineLiveScores($fixture, $deviceType); // Implement this function
                
                $livestatus = $liveScoresResults[0];
                $livescores = $liveScoresResults[1];

            // Prepare shared details
                $sharedTableDetailsArray[] = [
                    'game_details' => $fixture,
                    'home_odd' => $homeOdd,
                    'draw_odd' => $drawOdd,
                    'away_odd' => $awayOdd,
                    'probability_results'=> $probability_results,
                    'winning_odd' => $winning_odd,
                    'winning_team' => $winning_team,
                    'livestatus' => $livestatus,
                    'livescores' => $livescores,
                    'halftime_data' => $halftimeData,
                    'extratime_data' => $extratimeData,
                    'penalty_data' => $penaltyData,
                    'average' => $fixturesAverage,
                    // Include halftime details if applicable
                    ...(strpos($_SERVER['REQUEST_URI'], "predictions-halftime-fulltime") !== false ? [
                        'ht_home_odd' => $htHomeOdd,
                        'ht_draw_odd' => $htDrawOdd,
                        'ht_away_odd' => $htAwayOdd,
                    ] : []),
                ];

                $predictionsList[] = [
                    'sharedTableDetails' => $sharedTableDetailsArray,
                    'isMobile' => $isMobile,
                ];
            }
        }
    }

    return $sharedTableDetailsArray; // Return predictions data
}