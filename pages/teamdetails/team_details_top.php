<?php
include_once __DIR__ . "/../../components/functions/DatetimetoUsersTimezone.php";
include_once __DIR__ . "/../../components/functions/double_chance_probability_results.php";
include_once __DIR__ . "/../../components/functions/double_chance_winning_team_and_odd.php";
include_once __DIR__ . "/../../components/functions/FetchfixturesById-Myfavourites.php";
include_once __DIR__ . "/../../components/functions/OverUnderProbabilitiesScale.php";
include_once __DIR__ . "/../../components/functions/getDeviceType.php";   
require_once __DIR__ . '/../../components/functions/determine_winning_team_and_odd.php';
require_once __DIR__ . '/../../components/functions/determine_probability_results.php'; 
require_once __DIR__ . '/../../components/functions/match_outcomes_home_drawings.php';

function getTeamDetailsTopData($url) {
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request and fetch the response
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    // Close cURL session
    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Extract "data" field if it exists
    $processing_data = isset($data['data']) ? $data['data'] : null;

    return $processing_data;
}

function renderTeamsDetailsTop($game_details, $team_id) {
    $deviceType = getDeviceType(); // Assuming this function detects the device type
    // Begin HTML structure
    ?>
    <div class="mb-2"> 
        <div class="col-sm-12 text-left text-nowrap">
            <div class="container d-flex align-items-center">
                <img src="<?= htmlspecialchars($game_details[0]['downloaded_country_flag'] ?? $game_details[0]['game_details']['downloaded_league_logo']) ?>" 
                    class="img-fluid league-logo" 
                    alt="<?= htmlspecialchars($game_details[0]['country_name']) ?>-football-predictions" 
                    loading="lazy"
                    style="width: 20px; height: auto; margin-right: 8px;" />
                
                <span style="font-weight: bold; white-space: nowrap;" class="fixturesTextSize">
                    <a href="<?= "/football-predictions-for-" . strtolower($game_details[0]['country_name']) . "/fixtures" ?>" class="ml-2 aTxt"><?= strtoupper(htmlspecialchars($game_details[0]['country_name'])) ?></a>
                    &nbsp;:&nbsp;
                    <a href="<?= "/football-predictions-for-" . strtolower($game_details[0]['country_name']) . "/" . strtolower(str_replace(' ', '-', $game_details[0]['league_name'])) . "-" . $game_details[0]['league_id'] . "/fixtures" ?>" class="ml-2 aTxt"><?= strtoupper(htmlspecialchars($game_details[0]['league_name'])) ?></a>
                </span>
            </div>
        </div>
    </div>

    <div class="row fixturesTextSize">                   
        <div class="col-md-6 col-sm-12" style="text-align:left">  
            <div class="row container align-items-center"> <!-- Align items vertically centered -->
                <div class="col-4">
                    <img class="teamimage_class" 
                        src="<?= ($team_id === $game_details[0]["home_team_id"]) ? $game_details[0]["home_team_logo"] : $game_details[0]["away_team_logo"] ?>" 
                        alt="<?= htmlspecialchars(($team_id === $game_details[0]["home_team_id"]) ? $game_details[0]["home_team_name"] : $game_details[0]["away_team_name"]) ?>-predictions-and-fixtures"/> 
                </div>
                <div class="col-8 fixturesTextSize">
                    <h6 style="font-weight: bold; white-space: nowrap; display: inline-block;">
                        <?= htmlspecialchars(($team_id === $game_details[0]["home_team_id"]) ? $game_details[0]["home_team_name"] : $game_details[0]["away_team_name"]) ?>
                    </h6>
                </div>
            </div>              
        </div>
        <div class="col-md-3 col-sm-0"></div>                   
    </div>
    <?php
}
?>
