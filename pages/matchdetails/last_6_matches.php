<?php
include_once __DIR__ . "/../../components/functions/DatetimetoUsersTimezone.php";
include_once __DIR__ . "/../../components/functions/Compute_win_drawings.php";

function Last6Matches($home_team_name, $away_team_name, $home_team_id, $away_team_id, $fixtureDate, $leagueId) {
    // Initialize variables and arrays
    $home_team_name = $home_team_name;
    $away_team_name = $away_team_name;
    $loading1 = false;
    $loading2 = false;
    $home_team_matches_array = [];
    $last_6matches_leagues_url = "https://api.pitchpredictions.com/api/fetch_last_6_matches_leagues";
    $home_team_last6_matches_leagues = [];
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];
    $homeTeamNum = 10;
    $awayTeamNum = 10;
    $activeLeagueIdHome = null;
    $activeLeagueIdAway = null;
    $home_team_matches_url = "https://api.pitchpredictions.com/api/fetch_last_six_matches_by_home_team";
    $away_team_matches_url = "https://api.pitchpredictions.com/api/fetch_last_six_matches_by_away_team";

    $home_team_matches_data = fetchHomeLast6MatchesLeaguesByTeamId($home_team_id, $fixtureDate, $last_6matches_leagues_url, $headers);
   
    $away_team_matches_data = fetchAwayLast6MatchesLeaguesByTeamId($away_team_id, $fixtureDate, $last_6matches_leagues_url, $headers);
    
    $filterHomepageGames = filterHomeMatchesByLeagues($home_team_id, $leagueId, $fixtureDate);
    $filterAwaypageGames = filterHomeMatchesByLeagues($away_team_id, $leagueId, $fixtureDate);

    $fetchLast6MatchesHome = fetchLast6MatchesHome($home_team_matches_url, $home_team_id, $fixtureDate);
    $fetchLast6MatchesAway = fetchLast6MatchesAway($away_team_matches_url, $away_team_id, $fixtureDate);

    if($fetchLast6MatchesHome["message"] === "success"){
        echo renderMatchHeaders($home_team_matches_data["data"], $home_team_name, $leagueId);
        echo renderMatchDetails($fetchLast6MatchesHome["data"], $home_team_id);
        echo "<br/>";
    }
    
    if($fetchLast6MatchesAway["message"] === "success"){
        echo renderMatchHeaders($away_team_matches_data["data"], $away_team_name, $leagueId);
        echo renderMatchDetails($fetchLast6MatchesAway["data"], $away_team_id);
    }
    
    ob_start();

    return ob_get_clean();
}

function fetchHomeLast6MatchesLeaguesByTeamId($homeTeamId, $fixtureDate, $last6MatchesLeaguesUrl, $headers) {
    // Initialize cURL
    $ch = curl_init();

    // Prepare the payload
    $postData = json_encode([
        'home_team_id' => $homeTeamId,
        'fixture_date' => $fixtureDate
    ]);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $last6MatchesLeaguesUrl);
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

function fetchAwayLast6MatchesLeaguesByTeamId($awayTeamId, $fixtureDate, $last6MatchesLeaguesUrl, $headers) {
    // Initialize cURL
    $ch = curl_init();

    // Prepare the payload
    $postData = json_encode([
        'home_team_id' => $awayTeamId,
        'fixture_date' => $fixtureDate
    ]);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $last6MatchesLeaguesUrl);
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
        $_SESSION['away_team_last_6_matches_leagues'] = $last6MatchesData;

        // Check if league ID is present in data
        $activeLeagueIdAway = isset($_SESSION['active_league_id_away']) ? $_SESSION['active_league_id_away'] : null;
        $hasLeagueId = array_filter($last6MatchesData, function ($item) use ($activeLeagueIdAway) {
            return $item['league_id'] == $activeLeagueIdAway;
        });

        // Set active league ID
        $_SESSION['active_league_id_away'] = $hasLeagueId ? $activeLeagueIdAway : 'all';
    }

    return $data;
}

function filterHomeMatchesByLeagues($teamId, $leagueId, $fixtureDate) {
    // Show preloader (set a loading flag if needed)
    $loading1 = true;

    $last_6matches_filtered_url = "https://api.pitchpredictions.com/api/fetch_last_six_matches_filtered_by_league";
    $headers = [
        "Content-type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];
    
    try {
        // Prepare the data payload
        $postData = [
            'home_team_id' => $teamId,
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

function filterAwayMatchesByLeagues($teamId, $leagueId, $fixtureDate) {
    // Show preloader (set a loading flag if needed)
    $loading1 = true;

    $last_6matches_filtered_url = "https://api.pitchpredictions.com/api/fetch_last_six_matches_filtered_by_league";
    $headers = [
        "Content-type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];
    
    try {
        // Prepare the data payload
        $postData = [
            'home_team_id' => $teamId,
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
            $awayTeamMatches = $data['data'];

            // Set active league in the session (alternative to localStorage)
            $_SESSION['active_league_id_away'] = $leagueId;
            // $isActive = $leagueId === $props['activeLeagueIdHome'];
            $activeLeagueIdAway = $leagueId;
        }
    } catch (Exception $e) {
        // Handle any errors
        error_log($e->getMessage());
    } finally {
        // Hide preloader (update loading flag if needed)
        $loading1 = false;
    }
    
    // Return the results if needed
    return $awayTeamMatches ?? [];
}

function fetchLast6MatchesHome($home_team_matches_url, $home_team_id, $unformatted_date) {
    // Define the headers
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    // Prepare the data payload
    $data = [
        "home_team_id" => $home_team_id,
        "fixture_date" => $unformatted_date
    ];

    // Initialize cURL
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $home_team_matches_url);
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

function fetchLast6MatchesAway($away_team_matches_url, $away_team_id, $unformatted_date) {
    // Define the headers
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    // Prepare the data payload
    $data = [
        "away_team_id" => $away_team_id,
        "fixture_date" => $unformatted_date
    ];

    // Initialize cURL
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $away_team_matches_url);
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

function renderMatchHeaders($team_last6_matches_leagues, $team_name, $activeLeagueIdHome) {
    ?>
    <div class="text-center fw-bold sectionTitle">
        <span>LAST MATCHES: <?= strtoupper($team_name); ?></span><br/>
    </div>
    
    <!-- Scroll Nav -->
    <div class="container">
        <div class="responsive-row header matchdetailsheader">
            <div class="flex-grow-1 w-100 o-hidden">
                <ul class="nav scrollable nav-fill position-relative flex-nowrap">
                    <li id="<?= count($team_last6_matches_leagues) > 1 ? 'leagueNavClick' : ''; ?>" 
                        class="nav-item" 
                        style="text-align: left; max-width: 15%; background-color: <?= $activeLeagueIdHome == 'all' ? '#eb4d68' : ''; ?>"
                        onclick="allawayfixtureslast6matches()">
                        <a class="nav-link link-light last6mhovereffects">All</a>
                    </li>
                    
                    <?php foreach ($team_last6_matches_leagues as $league): ?>
                        <li class="nav-item" 
                            style="background-color: <?= $league['league_id'] == $activeLeagueIdHome ? '#eb4d68' : ''; ?>"
                            onclick="filterHomeMatchesByLeagues(<?= $league['league_id']; ?>)">
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
            <div class="responsive-cell team-link-probability"></div>
        </div>
    </div>
    <?php
}

function renderMatchDetails($matches, $team_id) {
    $output = '';
    foreach (array_slice($matches, 0, 6) as $match) {
        $url_name = urlencode(strtolower(str_replace(' ', '-', $match['home_team_name'] . '-vs-' . $match['away_team_name'] . '-' . $match['fixture_id'])));
        
        $boldHome = ($match['home_team_id'] == $team_id) ? 'font-weight: bold;' : '';
        $boldAway = ($match['away_team_id'] == $team_id) ? 'font-weight: bold;' : '';

        $output .= '
            <div class="container">
            <a href="/football-predictions-' . $url_name . '" title="Click to View Match details">
                <div class="responsive-row fixturesTextSize matchDetailsLink">
                    <div class="responsive-cell team-link-probability" style="text-align: left;">' . $match['date'] . '</div>
                    <div class="responsive-cell team-link-probability">
                        <div style="display: flex; align-items: center;">
                            <img src="' . $match['logo'] . '" class="league_image_logo" alt="' . strtolower(str_replace(' ', '-', $match['league_name'])) . '-football-predictions" style="background-color: whitesmoke; margin-right: 10px;" loading="lazy"/>
                            <span>' . $match['league_short_name'] . '</span>
                        </div>
                    </div>
                    <div class="responsive-cell team-link" style="text-align: left;">
                        <div style="' . $boldHome . '">' . $match['home_team_name'] . '</div>
                        <div style="' . $boldAway . '">' . $match['away_team_name'] . '</div>
                    </div>
                    <div class="responsive-cell team-link-probability">
                        <span>' . $match['goals_home'] . ' - ' . $match['goals_away'] . '</span>
                        <br />
                        <span>(' . json_decode($match['scores'], true)['halftime']['home'] . ' - ' . json_decode($match['scores'], true)['halftime']['away'] . ')</span>
                    </div>
                    <div class="responsive-cell team-link-probability">' . ComputedWinDrawings($team_id, $match['home_team_id'], $match['away_team_id'], $match['goals_home'], $match['goals_away']) . '</div>
                </div>
            </a>
            </div>';
    }
    return $output;
}
?>
