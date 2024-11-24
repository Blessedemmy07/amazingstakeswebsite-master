<?php
include_once __DIR__ . "/../components/shared/preloader.shared.php";
include_once __DIR__ . "/../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../components/shared/fixtures_table_display.shared.php";
include_once __DIR__ . "/../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../components/shared/datanotfound.shared.php";

$currentDate = date('Y-m-d'); // Current date
// Set the API URL for fetching predictions
$apiUrl = "https://backend.sokapedia.com/api/fetch_todays_games?fixture_date=".$currentDate; 

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

//Seo Content
include_once __DIR__ . "/../components/seo-content/todays-prediction.content.php";

include_once __DIR__ . "/../components/layouts/bottom-layout.layout.php";

?>
<script type='text/javascript' src='//comparativehoneycomb.com/1b/a7/51/1ba75145782e255c107ddf6ce93e1286.js'></script>
