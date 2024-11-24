<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../../components/shared/fixture_by_leagues_display.shared.php";
include_once __DIR__ . "/../../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../../components/shared/datanotfound.shared.php";

// Retrieve the country name from the URL
$country_name = isset($_GET['country_name']) ? $_GET['country_name'] : 'default_country'; 

$league_name = isset($_GET['league_name']) ? $_GET['league_name'] : 'default_league';

$league_id = isset($_GET['league_id']) ? $_GET['league_id'] : 'default_league_id';

$currentDate = date('Y-m-d'); // Current date

// Set the API URL for fetching predictions
$apiUrl = "https://api.pitchpredictions.com/api/fetch_todays_fixtures_by_league_id?league_id=". $league_id."&fixture_date=" . $currentDate;

//Authorization header
$headers = [
'Authorization' => 'UJlhuDILIR1Lc2IEwZDIKOln9d'
];

// Call the function to get match prediction details
$todaysPredictions = getMatchPredictionDetails($apiUrl, $headers);

if (count($todaysPredictions) > 0) {
    ?>
    <div class="mb-2">
        <div class="desktop-container-resize mb-1">
            <div class="col-sm-12 text-center bg-light pt-1">
                <h2 class="sectionTitle">Today's Fixtures - <?php echo htmlspecialchars($country_name); ?>, <?php echo htmlspecialchars($league_name); ?></h2>
            </div>
        </div>
    </div>
    <?php

    $fixture_details = FixtureByLeaguesDetails($todaysPredictions);
}

// Set the API URL for fetching predictions
$apiUrl1 = "https://backend.sokapedia.com/api/fetch_league_fixtures?league_name=".$league_name."&country_name=". urlencode($country_name);

//Authorization header
$headers1 = [
'Authorization' => 'FujistuXIlIV1Li2IKwZDIKSln8c1'
];

// Call the function to get match prediction details
$predictions = getMatchPredictionDetails($apiUrl1, $headers1);

if (count($predictions) > 0) {
    ?>
    <div class="mb-2">
        <div class="desktop-container-resize mb-1">
            <div class="col-sm-12 text-center bg-light pt-1">
                <h2 class="sectionTitle">Upcoming Fixtures - <?php echo htmlspecialchars($country_name); ?> , <?php echo htmlspecialchars($league_name); ?></h2>
            </div>
        </div>
    </div>
    <?php

    $fixture_details = FixtureByLeaguesDetails($predictions);

} else {
    $fixture_details = renderDataNotFound();
}

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";
?>