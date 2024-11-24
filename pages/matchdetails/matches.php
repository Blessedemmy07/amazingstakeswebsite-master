<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__.'/match_details_top.php';
include_once __DIR__.'/h2h_matches.php';
include_once __DIR__.'/last_6_matches.php';
include_once __DIR__.'/../../components/shared/datanotfound.shared.php';
include_once __DIR__.'/../../components/shared/display_standings.shared.php';
include_once __DIR__ . "/../../components/functions/getDeviceType.php";

function matchDetails() {
    // Initialize variables
    $matchDetailsData = []; 
    // Get the request URI
    $currentUrl = $_SERVER['REQUEST_URI'];
    $deviceType = getDeviceType();

    $fixtureIdInteger = 0;
    if ($currentUrl) {
        // Match the number at the end of the URI
        if (preg_match('/(\d+)$/', $currentUrl, $matches)) {
            $fixtureIdInteger = (int) $matches[1];
        }
    }
    // URLs for API endpoints
    $url = "https://api.pitchpredictions.com/api/fetch_match_details_top_data?fixture_id=" . $fixtureIdInteger;

    // Fetch match details top data
    $gameDetails = getMatchDetailsTopData($url);

    if ($gameDetails) {
        $matchDetailsData = $gameDetails[0]; 

        renderMatchDetailsTop($gameDetails);
        echo "<br/>";

        H2hMatches($matchDetailsData['home_team_id'],$matchDetailsData["away_team_id"],$matchDetailsData["unformated_date"], $matchDetailsData["league_id"]);
        echo "<br/>";

        Last6Matches($matchDetailsData["home_team_name"], $matchDetailsData['away_team_name'], $matchDetailsData['home_team_id'],$matchDetailsData["away_team_id"],
        $matchDetailsData["unformated_date"], $matchDetailsData["league_id"]);
        echo "<br/>";
        
        DisplayStandings($matchDetailsData["league_id"], $matchDetailsData['home_team_id'],$matchDetailsData["away_team_id"], $deviceType);
    }
}

matchDetails();

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";

?>
