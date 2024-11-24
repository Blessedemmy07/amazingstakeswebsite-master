<?php
include_once __DIR__ . "/../../components/functions/DatetimetoUsersTimezone.php";

function H2hMatches($home_team_id, $away_team_id, $fixtureDate, $leagueId) {
    // Initialize variables and arrays
    $loading1 = false;
    $loading2 = false;
    $home_team_matches_array = [];
    $h2h_url = "https://api.pitchpredictions.com/api/fetch_h2h_league";

    $home_team_last6_matches_leagues = [];
    $away_team_last6_matches_leagues = [];
    $home_team_last6_matches_leagues_display_array = [];
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    $homeTeamNum = 10;
    $awayTeamNum = 10;
    $activeLeagueIdHome = null;
    $activeLeagueIdAway = null;
    $h2h_team_matches_url = "https://api.pitchpredictions.com/api/fetch_h2h_fixtures";

    $h2h_leagues_filters = fetchH2HLeagues($home_team_id,$away_team_id, $fixtureDate, $h2h_url, $headers);
       
    $filterHomepageGames = filterMatchesByLeagues($home_team_id, $away_team_id, $leagueId, $fixtureDate);

    $fetchLast6MatchesH2h = getH2HData($h2h_team_matches_url, $home_team_id, $away_team_id, $fixtureDate);

    if($h2h_leagues_filters["message"] == "success") {
        echo h2hrenderMatchHeaders($h2h_leagues_filters["data"], $leagueId);    
    }

    if($fetchLast6MatchesH2h["message"] == "success") {
        echo h2hrenderMatchDetails($fetchLast6MatchesH2h["data"]);
    }

    ob_start();

    return ob_get_clean();
}

function fetchH2HLeagues($homeTeamId, $awayTeamId, $fixtureDate, $h2h_url, $headers) {
    // Initialize cURL
    $ch = curl_init();

    // Prepare the payload
    $postData = json_encode([
        'home_team_id' => $homeTeamId,
        'away_team_id' => $awayTeamId,
        'fixture_date' => $fixtureDate
    ]);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $h2h_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, ["Content-Type: application/json"]));

    // Execute cURL request
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return ['error' => curl_error($ch)];
    }

    curl_close($ch);

    // Decode JSON response
    $data = json_decode($response, true);

    if ($data['status'] === true) {
        $last6MatchesData = $data['data'];

        // Store data (you might want to replace with appropriate storage in PHP)
        $_SESSION['home_team_last_6_matches_leagues'] = $last6MatchesData;

        // Check if league ID is present in data
        $activeLeagueIdHome = isset($_SESSION['active_league_id_home']) ? $_SESSION['active_league_id_home'] : null;
        $hasLeagueId = array_filter($last6MatchesData, function ($item) use ($activeLeagueIdHome) {
            return $item['league_id'] == $activeLeagueIdHome;
        });

        // Set active league ID
        $_SESSION['active_league_id_home'] = $hasLeagueId ? $activeLeagueIdHome : 'all';
    }

    return $data;
}

function filterMatchesByLeagues($home_team_id, $away_team_id, $leagueId, $fixtureDate) {
    // Show preloader (set a loading flag if needed)
    $loading1 = true;

    $last_6matches_filtered_url = "https://api.pitchpredictions.com/api/fetch_h2h_fixtures_by_league";
    $headers = [
        "Content-type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];
    
    try {
        // Prepare the data payload
        $postData = [
            'home_team_id' => $home_team_id,
            'away_team_id' => $away_team_id,
            'league_id' => $leagueId,
            'fixture_date' => $fixtureDate
        ];

        // Initialize cURL
        $ch = curl_init($last_6matches_filtered_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request and get the response
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if ($data['status'] == true) {
            // Update matches with filtered data
            $homeTeamMatches = $data['data'];

            // Set active league in the session (alternative to localStorage)
            $_SESSION['active_league_id_home'] = $leagueId;
            // $isActive = $leagueId === $props['activeLeagueIdHome'];
            $activeLeagueIdHome = $leagueId;
        }
    } catch (Exception $e) {
        // Handle any errors
        error_log($e->getMessage());
    } finally {
        // Hide preloader (update loading flag if needed)
        $loading1 = false;
    }
    
    // Return the results if needed
    return $homeTeamMatches ?? [];
}

function getH2HData($h2h_team_matches_url, $home_team_id, $away_team_id, $unformatted_date) {
    // Define the headers
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    // Prepare the data payload
    $data = [
        "home_team_id" => $home_team_id,
        "away_team_id" => $away_team_id,
        "fixture_date" => $unformatted_date
    ];

    // Initialize cURL
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $h2h_team_matches_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute the request
    $response = curl_exec($ch);

    // Check for cURL errors
    if ($response === false) {
        echo "cURL Error: " . curl_error($ch);
        return null;
    }

    // Close cURL
    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);
    
    return $data;
}

function h2hrenderMatchHeaders($team_h2h_matches_leagues, $activeLeagueIdHome) {
    ?>
    <div class="text-center fw-bold sectionTitle">
        <span>HEAD-TO-HEAD MATCHES</span><br/>
    </div>
    
    <!-- Scroll Nav -->
    <div class="container">
        <div class="responsive-row header matchdetailsheader">
            <div class="flex-grow-1 w-100 o-hidden">
                <ul class="nav scrollable nav-fill position-relative flex-nowrap">
                    <li id="<?= count($team_h2h_matches_leagues) > 1 ? 'leagueNavClick' : ''; ?>" 
                        class="nav-item" 
                        style="text-align: left; max-width: 15%; background-color: <?= $activeLeagueIdHome == 'all' ? '#eb4d68' : ''; ?>"
                        onclick="allawayfixtureslast6matches()">
                        <a class="nav-link link-light last6mhovereffects">All</a>
                    </li>
                    
                    <?php foreach ($team_h2h_matches_leagues as $league): ?>
                        <li class="nav-item" 
                            style="background-color: <?= $league['league_id'] == $activeLeagueIdHome ? '#eb4d68' : ''; ?>"
                            onclick="filterMatchesByLeagues(<?= $league['league_id']; ?>)">
                            <a class="nav-link link-light last6mhovereffects"><?= htmlspecialchars($league['league_name']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
                
        <div class="responsive-row header fixturesTextSize" style="cursor: auto;">
            <div class="responsive-cell team-link-probability" style="text-align: left;">Date</div>
            <div class="responsive-cell team-link-probability" style="text-align: left;">League</div>
            <div class="responsive-cell team-link" style="text-align: left;">Match</div>
            <div class="responsive-cell team-link-probability">Score</div>
        </div>
    </div>
    <?php
}

function h2hrenderMatchDetails($matches) {
    $output = '';
    $uniqueMatches = [];
    
    foreach ($matches as $match) {
        // Check if fixture_id has already been processed
        if (in_array($match['fixture_id'], $uniqueMatches)) {
            continue; // Skip this match if it's already in the array
        }
        
        // Add the fixture_id to the uniqueMatches array
        $uniqueMatches[] = $match['fixture_id'];

        // Generate the URL-friendly name
        $url_name = urlencode(strtolower(str_replace(' ', '-', $match['home_team_name'] . '-vs-' . $match['away_team_name'] . '-' . $match['fixture_id'])));

        $output .= '
        <div class="container">
            <a href="/football-predictions-' . $url_name . '" title="Click to View Match details">
                <div class="responsive-row fixturesTextSize matchDetailsLink">
                    <div class="responsive-cell team-link-probability" style="text-align: left;">' . ($match['match_date'] ?? '') . '</div>
                    <div class="responsive-cell team-link-probability">
                        <div style="display: flex; align-items: center;">
                            <img src="' . htmlspecialchars($match['downloaded_league_logo'] ?? '') . '" class="league_image_logo" alt="' . htmlspecialchars(strtolower(str_replace(' ', '-', $match['league_name'] ?? ''))) . '-football-predictions" style="background-color: whitesmoke; margin-right: 10px;" loading="lazy"/>
                            <span>' . htmlspecialchars($match['league_short_name'] ?? '') . '</span>
                        </div>
                    </div>
                    <div class="responsive-cell team-link" style="text-align: left;">
                        <div style="color: ' . (($match["ft_goals_home"] ?? 0) > ($match["ft_goals_away"] ?? 0) ? 'black' : '') . ';
                                    font-weight: ' . (($match["ft_goals_home"] ?? 0) > ($match["ft_goals_away"] ?? 0) ? 'bold' : '') . ';
                                    white-space: pre-wrap;">' . htmlspecialchars($match['home_team_name'] ?? '') . '</div>
                        <div style="color: ' . (($match["ft_goals_away"] ?? 0) > ($match["ft_goals_home"] ?? 0) ? 'black' : '') . ';
                                    font-weight: ' . (($match["ft_goals_away"] ?? 0) > ($match["ft_goals_home"] ?? 0) ? 'bold' : '') . ';
                                    white-space: pre-wrap;">' . htmlspecialchars($match['away_team_name'] ?? '') . '</div>
                    </div>
                    <div class="responsive-cell team-link-probability">
                        <span>' . htmlspecialchars($match['ft_goals_home'] ?? '0') . ' - ' . htmlspecialchars($match['ft_goals_away'] ?? '0') . '</span>
                    </div>                
                </div>
            </a>
        </div>';

        
        // Stop adding matches after 6 unique ones have been processed
        if (count($uniqueMatches) >= 6) {
            break;
        }
    }
    return $output;
}

?>
