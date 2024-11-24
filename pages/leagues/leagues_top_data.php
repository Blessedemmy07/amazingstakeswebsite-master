<?php
function fetchLeagueTopData($league_id, $authorization) {
    // Set the API URL with the provided league ID
    $apiUrl = "https://api.pitchpredictions.com/api/fetch_leagues_top_data?league_id=" . $league_id;

    // Set up the HTTP headers and request method
    $options = [
        'http' => [
            'header' => "Authorization: " . $authorization,
            'method' => 'GET',
        ],
    ];

    // Create a stream context and make the API request
    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    // Decode the JSON response into an associative array
    $data = json_decode($response, true);

    // Check if the response is valid and contains data
    if ($data && isset($data['data'][0])) {
        return $data['data'][0];
    } else {
        return null; // Return null if no data is available
    }
}

$leagueData = fetchLeagueTopData($league_id, $authorization);

// Only proceed if data is successfully retrieved
if ($leagueData) {
    $country_name = $leagueData['country_name'];
    $league_name = $leagueData['league_name'];
    $country_flag = $leagueData['downloaded_country_flag'];
    $league_logo = $leagueData['downloaded_league_logo'];
?>

<div class="col-sm-12 text-left text-nowrap pb-1 pt-1 mb-2">
    <div class="container">
        <img src="<?php echo htmlspecialchars($country_flag); ?>" 
             class="img-fluid league-logo" 
             alt="<?php echo htmlspecialchars($country_name . '-football-predictions'); ?>" 
             loading="lazy" />&nbsp;

        <span style="font-weight: bold; white-space: break-spaces;" class="fixturesTextSize">
            <a href="<?php echo '/football-predictions-for-' . urlencode(strtolower($country_name)) . '/fixtures'; ?>" 
               class="ml-2 linkTxt">
                <?php echo strtoupper(htmlspecialchars($country_name)); ?>
            </a>
        </span>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6 col-sm-12" style="text-align: left;">
        <div class="row container">
            <div class="col-3">
                <img src="<?php echo htmlspecialchars($league_logo); ?>" 
                     alt="<?php echo htmlspecialchars($league_name . '-predictions-and-fixtures'); ?>" 
                     class="heading__logo" 
                     style="height: auto; width: auto; max-width: 100%; max-height: 100%;" />
            </div>
            <div class="col-9">
                <span style="font-weight: bold; white-space: pre-wrap;">
                    <?php echo htmlspecialchars($league_name); ?>
                </span>
                <br/><br/>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-0"></div>
</div>
<?php
} 
?>