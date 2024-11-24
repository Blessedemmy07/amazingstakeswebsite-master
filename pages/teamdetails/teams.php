<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__.'/team_details_top.php';
include_once __DIR__.'/../../components/shared/datanotfound.shared.php';
include_once __DIR__ . "/../../components/functions/getDeviceType.php";
include_once __DIR__.'/team_matches.php';
include_once __DIR__.'/upcoming_matches.php';

// Get the request URI
$currentUrl = $_SERVER['REQUEST_URI'];

$teamIdInteger = 0;
if ($currentUrl) {
    // Match the number at the end of the URI
    if (preg_match('/(\d+)$/', $currentUrl, $matches)) {
        $teamIdInteger = (int) $matches[1];
    }
}

$url = "https://api.pitchpredictions.com/api/fetch_teams_details_top?team_id=" . $teamIdInteger;
$both_teams_matches_leagues_url = "https://api.pitchpredictions.com/api/fetch_teams_matches_both_sides";
$home_team_matches_leagues_url = "https://api.pitchpredictions.com/api/fetch_teams_matches_when_home";
$away_team_matches_leagues_url = "https://api.pitchpredictions.com/api/fetch_teams_matches_when_away";

// Fetch match details top data
$teamDetails = getTeamDetailsTopData($url);

if ($teamDetails) {
    $teamDetailsData = $teamDetails[0]; 

    renderTeamsDetailsTop($teamDetails, $teamIdInteger);
    echo "<br/>";

    GamesPlayedByTeam($both_teams_matches_leagues_url, $teamIdInteger,$teamDetailsData['unformated_date'], $teamDetailsData["league_id"], $teamDetailsData["home_team_name"], $title="Games Played By ".$teamDetailsData["home_team_name"]);
    echo "<br/>";

    GamesPlayedByTeam($home_team_matches_leagues_url, $teamIdInteger,$teamDetailsData['unformated_date'], $teamDetailsData["league_id"], $teamDetailsData["home_team_name"], $title="Home Matches");
    echo "<br/>";

    GamesPlayedByTeam($away_team_matches_leagues_url, $teamIdInteger,$teamDetailsData['unformated_date'], $teamDetailsData["league_id"], $teamDetailsData["away_team_name"], $title ="Away Matches");
    echo "<br/>";

    UpcomingGamesByTeam($teamIdInteger,$teamDetailsData['unformated_date'], $title ="Upcoming Matches");
}

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";
?>