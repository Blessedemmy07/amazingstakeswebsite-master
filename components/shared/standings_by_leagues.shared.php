<?php
include_once __DIR__ . "/../functions/standings_win_lose_form.php";
include_once __DIR__ . "/../functions/standing_description_color.php";

function DisplayLeaguesStandings($league_id, $deviceType) {
    // Retrieve the country name from the URL
    $country_name = isset($_GET['country_name']) ? $_GET['country_name'] : 'default_country'; 

    $league_name = isset($_GET['league_name']) ? $_GET['league_name'] : 'default_league';

    $league_id = isset($_GET['league_id']) ? $_GET['league_id'] : 'default_league_id';

    $fetched_standings = fetchTableStandings($league_id);

    echo displayIndependentLeagueStandings($fetched_standings["data"], $deviceType);
}

function fetchTableStandings($league_id) {
    $url = "https://backend.sokapedia.com/api/fetch_team_standings";
    $headers = [
        'Content-Type: application/json',
        "Authorization: FujistuXIlIV1Li2IKwZDIKSln8c1"
    ];

    // Prepare the data to be sent in the POST request
    $data = json_encode(['league_id' => $league_id]);

    // Initialize cURL
    $ch = curl_init($url);

    // Set the options for cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, ["Content-Type: application/json"]));

    // Execute the request and get the response
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        // Handle errors (for example, log the error)
        $error = curl_error($ch);
        curl_close($ch);
        return ["error" => "cURL error: $error"];
    }

    // Close cURL
    curl_close($ch);

    // Decode and return the JSON response
    return json_decode($response, true);
}

function displayIndependentLeagueStandings($standingsData, $deviceType) {
    if (empty($standingsData)) {
        return '';
    }

    $output = '';
    // Decode the JSON data from standings_data
    $standings = json_decode($standingsData[0]["standings_data"], true); // Decode as an associative array
    $dataStandings = $standings ?? [];

    $groups = [];
    $groupNumber = '';

    $standingsTableList = '';

    // Check if standings is decoded correctly and has data
    if (!empty($standings) && is_array($standings[0])) {
        $i = 1;

        // Loop through each team
        foreach ($standings[0] as $teamData) {   
            // Determine background color for home or away teams
            $descColor = !empty($teamData['description']) ? assignColorToDescription($teamData['description'])['color'] : '';
            $descStyle = $descColor ? "background-color: {$descColor}; color: white; border: 1px solid {$descColor}; border-radius: 5px;" : 'color: black;';

            // Team standings row
            $standingsTableList .= '
                <div class="responsive-row">
                    <div class="responsive-cell team-link-standings">
                        <span style="' . $descStyle . '" title="' . $teamData['description'] . '">&nbsp;' . ($i) . '.&nbsp;</span>
                    </div>
                    <div class="responsive-cell team-link" style="text-align: left;">
                        <a href="' . '/teams/' . urlencode(strtolower(str_replace(' ', '-', $teamData['team']['name']))) . '-' . $teamData['team']['id'] . '">' . $teamData['team']['name'] . '</a>
                    </div>
                    <div class="responsive-cell">' . $teamData['all']['played'] . '</div>
                    <div class="responsive-cell">' . $teamData['all']['win'] . '</div>
                    <div class="responsive-cell">' . $teamData['all']['draw'] . '</div>
                    <div class="responsive-cell">' . $teamData['all']['lose'] . '</div>
                    <div class="responsive-cell">' . $teamData['all']['goals']['for'] . '</div>
                    <div class="responsive-cell">' . $teamData['all']['goals']['against'] . '</div>
                    <div class="responsive-cell">' . $teamData['goalsDiff'] . '</div>
                    <div class="responsive-cell" style="font-weight: bold;">' . $teamData['points'] . '</div>';

                // Display form if it's not a mobile device and form data is available
                if ($deviceType =="desktop" && !empty($teamData['form'])) {
                    $standingsTableList .= '
                    <div class="responsive-cell team-link-y" style="display: flex;">
                        ' . StandingsFormWinLose($teamData['form'], $i + 1) . '
                    </div>';
                }

                $standingsTableList .= '</div>';
            $i++; 
        }
    }

    // Standings Table Header
    $output .= '
    <div class="container">
        <div class="fixturesTextSize">
            <div class="row">
                <div class="text-center fw-bold">
                    <h2 class="text-center fw-bold sectionTitle">Overall Standings</h2>
                </div>
            </div>
            <div class="responsive-wrapper">
                <div class="responsive-row header standingsheader" style="cursor: auto;">
                    <div class="responsive-cell team-link-standings">
                        POS
                    </div>
                    <div class="responsive-cell team-link" style="text-align: left;">
                        TEAM
                    </div>
                    <div class="responsive-cell">MP</div>
                    <div class="responsive-cell">W</div>
                    <div class="responsive-cell">D</div>
                    <div class="responsive-cell">L</div>
                    <div class="responsive-cell">GF</div>
                    <div class="responsive-cell">GA</div>
                    <div class="responsive-cell">+/-</div>
                    <div class="responsive-cell" style="font-weight: bold;">PTS</div>';
                    
        $output .= '
                </div>
                ' . $standingsTableList . '
                <br/>
                <div class="responsive-row" style="border: none">
                    <div class="responsive-cell team-link-average">';
        
        // Add color indicators and descriptions
        $colors = ["#FF0000", "#00FF00", "#0000FF"]; // Placeholder colors
        $descriptions = ["Champion", "Relegated", "Promotion"]; // Placeholder descriptions
            foreach ($colors as $index => $color) {
                $output .= '
                    <div class="responsive-cell team-link-average" style="flex-basis: 100%; max-width: 100%;">
                    <div style="background-color: ' . $color . '; color: ' . $color . '; border: 1px solid ' . $color . '; font-size: 11px; display: inline-block;">
                        &nbsp;1&nbsp;
                    </div>
                    </div>';
            }
        $output .= '
                </div>
                <div class="responsive-cell team-link-average" style="flex-basis: 100%; max-width: 100%; text-align: left">';
                foreach ($descriptions as $description) {
                    $output .= '<div>' . $description . '</div>';
                }

        $output .= '
                    </div>
                </div>
                <br/>
                <div class="responsive-wrapper">
                    <div class="responsive-cell" style="flex-basis: 100%; max-width: 100%; text-align: left;">
                        <p style="color: black; font-weight: bold;">When teams have an equal number of points, tiebreakers are determined by goal difference, number of victories, goals scored, and goals scored away.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>';

    return $output;
}


