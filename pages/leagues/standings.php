<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../../components/shared/fixture_by_leagues_display.shared.php";
include_once __DIR__ . "/../../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../../components/shared/datanotfound.shared.php";
include_once __DIR__ . "/../../components/shared/standings_by_leagues.shared.php";
include_once __DIR__ . "/../../components/functions/getDeviceType.php";

$deviceType = getDeviceType();

// Retrieve the country name from the URL
$country_name = isset($_GET['country_name']) ? $_GET['country_name'] : 'default_country'; 

$league_name = isset($_GET['league_name']) ? $_GET['league_name'] : 'default_league';

$league_id = isset($_GET['league_id']) ? $_GET['league_id'] : 'default_league_id';

$fetched_standings = fetchTableStandings($league_id);

DisplayLeaguesStandings($league_id, $deviceType);

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";

