<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../../components/shared/fixtures_table_display.shared.php";
include_once __DIR__ . "/../../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../../components/shared/datanotfound.shared.php";

// Set the API URL for fetching predictions
$apiUrl = "https://backend.sokapedia.com/api/fetch_jackpot_fixtures_by_name?jackpot_name=Mozzart Super Daily Jackpot"; 

//Authorization header
$headers = [
'Authorization' => 'FujistuXIlIV1Li2IKwZDIKSln8c1'
];

// Call the function to get match prediction details
$predictions = getMatchPredictionDetails($apiUrl, $headers);

if(count($predictions) > 0){
    $fixture_details = FixtureDetails($predictions);
} else {
    $fixture_details = renderDataNotFound();
}

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";