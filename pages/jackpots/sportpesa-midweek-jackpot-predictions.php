<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../../components/shared/fixtures_table_display.shared.php";
include_once __DIR__ . "/../../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../../components/shared/datanotfound.shared.php";

// Set the API URL for fetching predictions
$apiUrl = "https://backend.sokapedia.com/api/fetch_jackpot_fixtures_by_name?jackpot_name=Sportpesa Midweek Jackpot"; 

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
include_once __DIR__ . "/../../components/seo-content/sportpesa-midweek-jackpot-predictions.content.php";

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";

?>
<script src="https://d3u598arehftfk.cloudfront.net/prebid_hb_9313_15101.js" async> </script>
   <div  id='HB_Footer_Close_hbagency_space_132085'>
 <div id='HB_CLOSE_hbagency_space_132085'></div>
 <div id='HB_OUTER_hbagency_space_132085'>
<div id='hbagency_space_132085'></div>
 </div></div>
<script type='text/javascript' src='//comparativehoneycomb.com/1b/a7/51/1ba75145782e255c107ddf6ce93e1286.js'></script>
