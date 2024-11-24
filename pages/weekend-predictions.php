<?php
include_once __DIR__ . "/../components/shared/preloader.shared.php";
include_once __DIR__ . "/../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../components/shared/fixtures_table_display.shared.php";
include_once __DIR__ . "/../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../components/shared/datanotfound.shared.php";

// Get today's day of the week
$current_day = date("l");

// Determine the weekend dates based on today's day
if ($current_day == 'Saturday' || $current_day == 'Sunday') {
    // If today is Saturday or Sunday, get this weekend's dates
    $saturday_date = date("Y-m-d", strtotime("this Saturday")); // This Saturday
    $sunday_date = date("Y-m-d", strtotime("this Sunday")); // This Sunday
} else {
    // If today is Monday to Friday, get next weekend's dates
    $saturday_date = date("Y-m-d", strtotime("next Saturday")); // Next Saturday
    $sunday_date = date("Y-m-d", strtotime("next Sunday")); // Next Sunday
}

// Set the API URL for fetching predictions
$apiUrl = "https://backend.sokapedia.com/api/fetch_weekend_fixtures?saturday_date=" . $saturday_date . "&sunday_date=" . $sunday_date; 

//Authorization header
$headers = [
'Authorization' => 'FujistuXIlIV1Li2IKwZDIKSln8c1'
];

// Call the function to get match prediction details
$predictions = getMatchPredictionDetails($apiUrl, $headers);

if (count($predictions) > 0) {
    $fixture_details = FixtureDetails($predictions);
} else {
    $fixture_details = renderDataNotFound();
}

// SEO Content
include_once __DIR__ . "/../components/seo-content/weekend-predictions.content.php";
include_once __DIR__ . "/../components/layouts/bottom-layout.layout.php";
