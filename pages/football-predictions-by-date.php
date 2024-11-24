<?php
include_once __DIR__ . "/../components/shared/preloader.shared.php";
include_once __DIR__ . "/../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../components/shared/fixtures_table_display.shared.php";
include_once __DIR__ . "/../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../components/shared/datanotfound.shared.php";

// Get the date parameter from the query string
$selectedDate = isset($_GET['date']) ? $_GET['date'] : null;

if ($selectedDate) {
    // Set the API URL for fetching predictions
    $apiUrl = "https://backend.sokapedia.com/api/fetch_fixtures_by_date?fixture_date=".$selectedDate;

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
} else {
    // Handle the case where no date was provided
    echo "No date provided.";
}

include_once __DIR__ . "/../components/layouts/bottom-layout.layout.php";
