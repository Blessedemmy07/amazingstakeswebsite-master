<?php
include_once __DIR__ . "/../functions/CheckifFixtureIsSelected.php";
include_once __DIR__ . "/../functions/DatetimetoUsersTimezone.php";
include_once __DIR__ . "/../functions/double_chance_probability_results.php";
include_once __DIR__ . "/../functions/double_chance_winning_team_and_odd.php";
include_once __DIR__ . "/../functions/FetchfixturesById-Myfavourites.php";
include_once __DIR__ . "/../functions/OverUnderProbabilitiesScale.php";
include_once __DIR__ . "/../functions/under_over_probability_results.php";
include_once __DIR__ . "/../functions/under_over_winning_team_and_odd.php";
include_once __DIR__ . "/../functions/getDeviceType.php"; 
include_once __DIR__ . "/../shared/renders/display-fixtures.shared.php";
include_once __DIR__ . "/../shared/renders/leagues-fixtures.shared.php";

function FixtureByLeaguesDetails($data): void {
    // Group fixtures by league_id without sorting explicitly
    $groupedData = [];
    
    foreach ($data as $fixture) {
        $leagueId = $fixture['game_details']['round'];
        $groupedData[$leagueId][] = $fixture;
    }

    // Output a wrapper for the leagues
    $currentPath = $_SERVER['REQUEST_URI']; 
    $previousLeagueId = null; // Track the previous league ID for comparison
    $deviceType = getDeviceType();
    $totalLeaguesToShowInitially = 10; // Set how many leagues to show initially
    $displayedLeagues = 0; // Counter for displayed leagues

    echo '<div id="league-container">';

    foreach ($groupedData as $leagueId => $fixtures) {
        // If we've already displayed 10 leagues, wrap the remaining in a hidden section
        if ($displayedLeagues === $totalLeaguesToShowInitially) {
            echo '<div id="hidden-leagues" style="display: none;">'; // Begin hidden block
        }

        // Render the league header for the first fixture in each league group
        echo renderLeagueHeader($fixtures[0], $deviceType);
        
        // Increment the displayed leagues count
        $displayedLeagues++;

        foreach ($fixtures as $fixture_details) {
            // Call function to convert date time to user's timezone
            if (is_array($fixture_details) && isset($fixture_details['game_details'])) {
                $myNewDateString = DateTimeToUsersTimezone($fixture_details['game_details']['date']);

                $myNewDateString = explode(' ', $myNewDateString)[0]; 
            }

            // Initialize icon color and path variables
            $iconColor = "currentColor";
            $iconPath = "M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z";
        
            // Check if the fixture is selected and set icon color/path accordingly
            if (CheckiffixtureIsSelected($fixture_details['game_details']['fixture_id'])) {
                $iconColor = "red";
                $iconPath = "M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z";
            } else {
                $iconColor = "currentColor";
                $iconPath = "M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z";
            }

            // Form the dynamic URL
            $url_name = urlencode(strtolower(trim($fixture_details['game_details']['home_team_name'] . '-vs-' . $fixture_details['game_details']['away_team_name'] . '-' . $fixture_details['game_details']['fixture_id'])));

            // Match details page navigation
            $tooltipTitle = strpos($currentPath, "/[match-details]") === false ? "Click to open match details" : "";

            // Double chance and Over under code being used in landing page
            $double_chance_probs = DoubleChanceWinningTeamAndOdd($fixture_details['home_odd'], $fixture_details['draw_odd'], $fixture_details['away_odd'], $fixture_details['game_details'], $currentPath);
            $dc_winning_pred_value = DoubleChanceProbabilityResults($fixture_details['game_details'], $double_chance_probs[0], $currentPath);
            $winning_team_probs = UnderOverWinningTeamAndOdd($fixture_details['average'], "");
            $under_over_pred_value = UnderOverProbabilityResults($fixture_details['game_details'], $winning_team_probs[0], $currentPath);
            $over_under_prob_percentage = OverUnderProbabilitiesScale($fixture_details['average']);

            // Render the fixture details after rendering the league header
            echo renderFixtureDetails(
                $fixture_details, $iconColor, $iconPath, $tooltipTitle, $url_name,
                $myNewDateString, $under_over_pred_value, $over_under_prob_percentage, 
                $dc_winning_pred_value, $double_chance_probs[0], $deviceType
            );    
        }
    }

    // Close the hidden section and the league container
    if ($displayedLeagues > $totalLeaguesToShowInitially) {
        echo '</div>'; // End hidden block

        echo '<div class="load-more mb-2">
                <button id="load-more-btn" onclick="showHiddenLeagues()" class="btn btn-success btn-sm">Show All Matches</button>
            </div>';
    }
    echo '</div>'; // End league container

    // Add JavaScript for the "Load More" functionality
    echo '<script>
            function showHiddenLeagues() {
                document.getElementById("hidden-leagues").style.display = "block";
                document.getElementById("load-more-btn").style.display = "none";
            }
        </script>';
}


