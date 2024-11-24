<?php
include_once __DIR__ . "/../../components/functions/DatetimetoUsersTimezone.php";
include_once __DIR__ . "/../../components/functions/double_chance_probability_results.php";
include_once __DIR__ . "/../../components/functions/double_chance_winning_team_and_odd.php";
include_once __DIR__ . "/../../components/functions/FetchfixturesById-Myfavourites.php";
include_once __DIR__ . "/../../components/functions/OverUnderProbabilitiesScale.php";
include_once __DIR__ . "/../../components/functions/getDeviceType.php";   
require_once __DIR__ . '/../../components/functions/determine_winning_team_and_odd.php';
require_once __DIR__ . '/../../components/functions/determine_probability_results.php'; 
require_once __DIR__ . '/../../components/functions/determine_live_scores.php';
require_once __DIR__ . '/../../components/functions/Bothteamtoscore.php';
require_once __DIR__ . '/../../components/functions/match_outcomes_away_drawings.php';
require_once __DIR__ . '/../../components/functions/match_outcomes_home_drawings.php';

function getMatchDetailsTopData($url) {
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


function renderMatchDetailsTop($game_details) {
    $deviceType = getDeviceType();
    $home_odd = $draw_odd = $away_odd = "";
    
    if (!empty($game_details[0]['percent_pred_home']) && !empty($game_details[0]['percent_pred_draw']) && !empty($game_details[0]['percent_pred_away'])) {
        $home_odd = rtrim($game_details[0]['percent_pred_home'], '%');
        $draw_odd = rtrim($game_details[0]['percent_pred_draw'], '%');
        $away_odd = rtrim($game_details[0]['percent_pred_away'], '%');
    }
    
    $computed_winning_preds = WinningTeamAndOdd($home_odd, $draw_odd, $away_odd, $game_details[0]);
    $winning_team = $computed_winning_preds[0];

    $probability_results = ProbabilityResults($game_details[0], $winning_team);

    $dc_computed_winning_preds = DoubleChanceWinningTeamAndOdd($home_odd, $draw_odd, $away_odd, $game_details[0], "");
    $dc_winning_team = $dc_computed_winning_preds[0];

    $dc_probability_results = DoubleChanceProbabilityResults($game_details[0], $dc_winning_team, "");

    $both_team_to_score = BothTeamsToScore($game_details[0]);

    $livescores_results = DetermineLiveScores($game_details[0], $deviceType);

    $scores_data = json_decode($game_details[0]['scores'], true);
    $halftime_data = $extratime_data = $penalty_data = "";

    if ($scores_data) {
        $halftime_data = isset($scores_data['halftime']['home']) ? '(' . $scores_data['halftime']['home'] . ' - ' . $scores_data['halftime']['away'] . ')' : "";
        $extratime_data = isset($scores_data['extratime']['home']) ? $scores_data['extratime']['home'] . ' - ' . $scores_data['extratime']['away'] : "";
        $penalty_data = isset($scores_data['penalty']['home']) ? $scores_data['penalty']['home'] . ' - ' . $scores_data['penalty']['away'] : "";
    }
    ?>
    
    <div class="mb-2"> 
        <div class="col-sm-12 text-left text-nowrap">
            <div class="container d-flex align-items-center">
                <img src="<?= $game_details[0]['downloaded_country_flag'] ?? $game_details[0]['game_details']['downloaded_league_logo'] ?>" 
                    class="img-fluid league-logo" 
                    alt="<?= $game_details[0]['country_name'] ?>-football-predictions" 
                    loading="lazy"
                    style="width: 20px; height: auto; margin-right: 8px;" />
                
                <span style="font-weight: bold; white-space: nowrap;" class="fixturesTextSize">
                    <a href="<?= "/football-predictions-for-" . strtolower($game_details[0]['country_name']) . "/fixtures" ?>" class="ml-2 aTxt"><?= strtoupper($game_details[0]['country_name']) ?></a>
                    &nbsp;:&nbsp;
                    <a href="<?= "/football-predictions-for-" . strtolower($game_details[0]['country_name']) . "/" . strtolower(str_replace(' ', '-', $game_details[0]['league_name'])) . "-" . $game_details[0]['league_id'] . "/fixtures" ?>" class="ml-2 aTxt"><?= strtoupper($game_details[0]['league_name']) ?></a>
                </span>
            </div>
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-3"></div>
        <div class="col-6 text-center">
            <span class="text-center matchdetailsTextSize" style="font-family: Arial; font-weight: bold;"><?= DateTimeToUsersTimezone($game_details[0]['date']) ?></span>
        </div>
        <div class="col-3"></div>
    </div>
    
    <div class="row">
        <div class="col-4 text-center">
            <span class="matchdetailsTextSize mb-2" style="font-weight: bold; white-space: nowrap;">
                <a href="<?= "/teams/" . strtolower(str_replace(' ', '-', $game_details[0]['home_team_name'])) . "-" . $game_details[0]['home_team_id'] . "" ?>" class="ml-2 aTxt"><?= $game_details[0]['home_team_name'] ?></a>
            </span>
            <div>
                <a href="<?= "/teams/" . strtolower(str_replace(' ', '-', $game_details[0]['home_team_name'])) . "-" . $game_details[0]['home_team_id'] . "" ?>" class="ml-2 aTxt">
                    <img class="image_class" src="<?= $game_details[0]['home_team_logo'] ?>" alt="<?= $game_details[0]['home_team_name'] . "-predictions-and-fixtures" ?>"/>
                </a>
            </div>
        </div>
        <div class="col-4 text-center">
            <span style="font-weight: bold; margin-bottom: 10px;">
                <?= $probability_results ?>&nbsp;|&nbsp;<?= $dc_probability_results ?>&nbsp;|&nbsp;<?= $both_team_to_score ?>
            </span><br/>
            <span style="font-weight: bold;">
                <?= ($game_details[0]['percent_pred_home'] && $game_details[0]['percent_pred_draw'] && $game_details[0]['percent_pred_away']) ? " - " :
                    ($winning_team == '1' ? $home_odd . "%" : ($winning_team == 'X' ? $draw_odd . "%" : $away_odd . "%")) ?>
            </span>
            
            <span style="font-weight: bold;">
                <?php
                if ($game_details[0]['status_short'] === "AET" || $game_details[0]['status_short'] === "PEN") {
                    echo $extratime_data ? "<br />$extratime_data" : ($penalty_data ? "<br />$penalty_data" : "");
                }
                ?>
            </span>
            <br/>
            <?= $livescores_results[1] ?><br/>
            <?= $deviceType =="mobile" ? "" : "<br/>" ?>
            <span class="fixturesTextSize" style="color: #B11111; font-weight: bold;">
                <?= ($game_details[0]['status_short'] === "PEN" || $game_details[0]['status_short'] === "P") ? "AFTER PENALTIES" : 
                    ($game_details[0]['status_short'] === "AET" ? "AFTER EXTRA TIME" : 
                    ($game_details[0]['status_short'] === "NS" ? explode(' ', DateTimeToUsersTimezone($game_details[0]['date']))[1] : $game_details[0]['status_long'])) ?>
            </span><br/>
        </div>
        <div class="col-4 text-center">
            <span class="matchdetailsTextSize mb-2" style="font-weight: bold; white-space: nowrap;">
                <a href="<?= "/teams/" . strtolower(str_replace(' ', '-', $game_details[0]['away_team_name'])) . "-" . $game_details[0]['away_team_id'] . "" ?>" class="ml-2 aTxt"><?= $game_details[0]['away_team_name'] ?></a>
            </span>
            <div>
                <a href="<?= "/teams/" . strtolower(str_replace(' ', '-', $game_details[0]['away_team_name'])) . "-" . $game_details[0]['away_team_id'] . "" ?>" class="ml-2 aTxt">
                    <img class="image_class" src="<?= $game_details[0]['away_team_logo'] ?>" alt="<?= $game_details[0]['away_team_name'] . "-predictions-and-fixtures" ?>"/>
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-4 text-center fixturesTextSize">
            <?php MatchOutcomesHome($game_details[0], $game_details[0]["home_team_id"]); ?>
        </div>
        <div class="col-4"></div>
        <div class="col-4 text-center fixturesTextSize">
            <?php MatchOutcomesAway($game_details[0], $game_details[0]["away_team_id"]); ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-12 text-center fixturesTextSize">
            <span style="font-weight: bold; white-space: break-spaces;">Venue: <?= $game_details[0]['venue_name'] ?></span><br/>
        </div>
    </div>
    <br/>
    <?php
}
?>
