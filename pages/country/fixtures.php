<?php
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include_once __DIR__ . "/../../components/layouts/top-layout.layout.php";
include_once __DIR__ . "/../../components/shared/fixtures_table_display.shared.php";
include_once __DIR__ . "/../../components/shared/pages_match_predictions_details.shared.php";
include_once __DIR__ . "/../../components/shared/datanotfound.shared.php";

// Retrieve the country name from the URL
$country_name = isset($_GET['country_name']) ? $_GET['country_name'] : 'default_country'; // Provide a default value if needed

$currentDate = date('Y-m-d'); // Current date

// Set the API URL for fetching predictions
$apiUrl = "https://api.pitchpredictions.com/api/fetch_todays_fixtures_by_country_name?country_name=" . urlencode($country_name) . "&fixture_date=" . $currentDate;

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
                <h2 class="sectionTitle">Today's Fixtures - <?php echo htmlspecialchars($country_name); ?></h2>
            </div>
        </div>
    </div>
    <?php

    $fixture_details = FixtureDetails($todaysPredictions);
}

// Set the API URL for fetching predictions
$apiUrl1 = "https://backend.sokapedia.com/api/fetch_upcoming_fixtures_by_country?country_name=" . urlencode($country_name);

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
                <h2 class="sectionTitle">Upcoming Fixtures - <?php echo htmlspecialchars($country_name); ?></h2>
            </div>
        </div>
    </div>
    <?php

    $fixture_details = FixtureDetails($predictions);

} else {
    $fixture_details = renderDataNotFound();
}

// SEO Content
// include_once __DIR__ . "/../../components/seo-content/homepage.content.php";

include_once __DIR__ . "/../../components/layouts/bottom-layout.layout.php";
?>
