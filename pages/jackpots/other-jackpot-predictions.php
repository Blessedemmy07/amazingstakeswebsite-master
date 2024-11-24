<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../../components/shared/fixtures_table_display.shared.php";
include_once __DIR__ . "/../../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../../components/functions/getJackpotFilterName.php";
include_once __DIR__ . "/../../components/shared/datanotfound.shared.php";

// Get the jackpot name dynamically from the URL slug
$jackpot_name = returnJackpotNameSavedInDB($_SERVER['REQUEST_URI']);

// Set the dynamic API URL based on the jackpot name
$apiUrl = "https://backend.sokapedia.com/api/fetch_jackpot_fixtures_by_name?jackpot_name=" . urlencode($jackpot_name);

//Authorization header
$headers = [
    'Authorization' => 'FujistuXIlIV1Li2IKwZDIKSln8c1'
    ];
    
// Call the function to get match prediction details
$predictions = getMatchPredictionDetails($apiUrl, $headers);

// Process the fixture details
if(count($predictions) > 0){
    $fixture_details = FixtureDetails($predictions);
} else {
    $fixture_details = renderDataNotFound();
}

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";

?>
<script src="https://d3u598arehftfk.cloudfront.net/prebid_hb_9313_15101.js" async> </script>
   <div  id='HB_Footer_Close_hbagency_space_132085'>
 <div id='HB_CLOSE_hbagency_space_132085'></div>
 <div id='HB_OUTER_hbagency_space_132085'>
<div id='hbagency_space_132085'></div>
 </div></div>
