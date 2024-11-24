<?php
include_once __DIR__ . "/../../components/functions/DatetimetoUsersTimezone.php";
include_once __DIR__ . "/../../components/functions/Compute_win_drawings.php";

function UpcomingGamesByTeam($team_id, $fixtureDate, $title) {
    // Initialize variables and arrays
    $loading1 = false;
    $team_matches_array = [];
    $teams_matches_leagues_url = "https://api.pitchpredictions.com/api/fetch_upcoming_matches_home_team";
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];
    $homeTeamNum = 10;
       
    $fetchUpcomingTeamMatches = fetchUpcomingTeamMatches($teams_matches_leagues_url, $team_id, $fixtureDate);

    if($fetchUpcomingTeamMatches["message"] === "success"){
        echo renderUpcomingMatchHeaders($title);

        echo renderUpcomingMatchDetails($fetchUpcomingTeamMatches["data"], $team_id);
    }

    ob_start();

    return ob_get_clean();
}

function fetchUpcomingTeamMatches($teams_matches_leagues_url, $teamId, $unformatted_date) {
    // Define the headers
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    // Prepare the data payload
    $data = [
        "home_team_id" => $teamId,
        "fixture_date" => $unformatted_date
    ];

    // Initialize cURL
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $teams_matches_leagues_url);
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

function renderUpcomingMatchHeaders($title) {
    ?>
    <div class="text-center fw-bold sectionTitle">
        <span><?= strtoupper(htmlspecialchars($title)); ?></span><br/>
    </div>
    
    <!-- Scroll Nav -->
    <div class="container">       
        <div class="responsive-row header fixturesTextSize" style="cursor: auto;">
            <div class="responsive-cell team-link-probability">Date</div>
            <div class="responsive-cell team-link-probability" style="text-align: left;">Match</div>
            <div class="responsive-cell"></div>
            <div class="responsive-cell team-link-probability"></div>
            <div class="responsive-cell team-link-probability">League</div>
        </div>
    </div>
    <?php
}

function renderUpcomingMatchDetails($matches, $team_id) {
    $output = '';
    foreach (array_slice($matches, 0, 6) as $match) {
        $url_name = urlencode(strtolower(str_replace(' ', '-', $match['home_team_name'] . '-vs-' . $match['away_team_name'] . '-' . $match['fixture_id'])));
        
        $boldHome = ($match['home_team_id'] == $team_id) ? 'font-weight: bold;' : '';
        $boldAway = ($match['away_team_id'] == $team_id) ? 'font-weight: bold;' : '';

        $output .= '
            <div class="container">
                <a href="/football-predictions-' . $url_name . '" title="Click to View Match details">
                    <div class="responsive-row fixturesTextSize matchDetailsLink">
                        <div class="responsive-cell team-link-probability">' . htmlspecialchars(DateTimeToUsersTimezone($match['date'])) . '</div>
                        <div class="responsive-cell team-link-probability" style="text-align: left; ' . $boldHome . '">'
                            . htmlspecialchars($match['home_team_name']) .
                        '</div>
                        <div class="responsive-cell">-</div>
                        <div class="responsive-cell team-link-probability" style="text-align: left; ' . $boldAway . '">'
                            . htmlspecialchars($match['away_team_name']) .
                        '</div>
                        <div class="responsive-cell team-link-probability">' . htmlspecialchars($match['league_name']) . '</div>
                    </div>
                </a>
            </div>';
    }
    return $output;
}
?>
