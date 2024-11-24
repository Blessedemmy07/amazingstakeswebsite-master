<?php
// Render individual fixture matches 
function renderFixtureDetails($fixture_details, $iconColor, $iconPath, $toottiptitle, $url_name, $myNewDateString, $under_over_pred_value, $over_under_prob_percentage, $dc_winning_pred_value,$dc_pred_value2,$deviceType) {
    ob_start();

    $routerPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    ?>
    <div class="responsive-row fixturesTextSize fixturesWholeRow">
        <!-- Fixture details here -->
        <div class="responsive-cell">
            <?php
                echo "<br/>";
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?php echo $iconColor; ?>" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="<?php echo $iconPath; ?>" />
            </svg>
        </div>
        <div class="responsive-cell team-link" style="text-align: left; font-weight: bold;" title="<?php echo $toottiptitle ?>">
            <?php if (basename($_SERVER['REQUEST_URI']) !== "match/[match-details]"): ?>
                <a href="/football-predictions-<?php echo $url_name; ?>">
                    <div class="teamNameLink">
                        <span><?php echo $fixture_details['game_details']['home_team_name']; ?></span><br />
                        <span><?php echo $fixture_details['game_details']['away_team_name']; ?></span><br />
                        <span class="table-date-time"><?php echo $myNewDateString; ?></span>
                    </div>
                </a>
            <?php else: ?>
                <div>
                    <span><?php echo $fixture_details['game_details']['home_team_name']; ?></span><br />
                    <span><?php echo $fixture_details['game_details']['away_team_name']; ?></span><br />
                    <span class="table-date-time" style="font-weight: normal;"><?php echo $myNewDateString; ?></span>
                </div>
            <?php endif; ?>    

        </div>
        <div class="responsive-cell team-link-y <?php echo $deviceType == 'mobile' ? 'hide-on-mobile' : ''; ?>">
            <?php
            // Create an array of odds values for home, draw, and away
            $oddsValues = [
                'home' => $fixture_details['game_details']['bets_home'],
                'draw' => $fixture_details['game_details']['bets_draw'],
                'away' => $fixture_details['game_details']['bets_away']
            ];

            if ($deviceType === "desktop") { 
                foreach ($oddsValues as $key => $value) {
                    echo '<span class="odds-card" style="font-weight: ' . ($fixture_details['winning_odd'] == $value ? 'bold' : '') . '; border: ' . (($key === 'home' && $fixture_details['game_details']['goals_home'] > $fixture_details['game_details']['goals_away']) ? '1px solid green' : '') . ';">';
                    echo ($value === null) ? "&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;" : $value;
                    echo '</span>';
                }
            }else {
                foreach ($oddsValues as $key => $value) {
                    echo '<span class="odds-card" style="font-weight: ' . ($fixture_details['winning_odd'] == $value ? 'bold' : '') . '; border: ' . (($key === 'home' && $fixture_details['game_details']['goals_home'] > $fixture_details['game_details']['goals_away']) ? '1px solid green' : '') . ';">';
                    echo ($value === null) ? "&nbsp;&nbsp;-&nbsp;&nbsp;" : $value;
                    echo '</span>';
                }
            }
            ?>
        </div>       
        <div class="responsive-cell team-link-average hide-on-mobile" title="Average Goals" 
            style="
                color: 
                    <?php echo ($fixture_details['average'] === '-') ? 'black' : (
                            (intval($fixture_details['game_details']['goals_home']) + intval($fixture_details['game_details']['goals_away']) >= 3) ? 
                                ($fixture_details['average'] >= 2.5 ? 'green' : '') : 
                                ($fixture_details['average'] < 2.5 ? 'green' : '')
                        );
                    ?>;
                font-size: 
                    <?php echo 
                        (intval($fixture_details['game_details']['goals_home']) + intval($fixture_details['game_details']['goals_away']) >= 3) ? 
                            ($fixture_details['average'] >= 2.5 ? '15px' : '') : 
                            ($fixture_details['average'] < 2.5 ? '15px' : ''); 
                    ?>;
                font-weight: 
                    <?php echo ($fixture_details['average'] === '-') ? 'normal' : (
                        (intval($fixture_details['game_details']['goals_home']) + intval($fixture_details['game_details']['goals_away']) >= 3) ? 
                            ($fixture_details['average'] >= 2.5 ? 'bold' : '') : 
                            ($fixture_details['average'] < 2.5 ? 'bold' : '')); 
                    ?>;
            ">
            <?php echo $fixture_details['average']; ?>

            <!-- Check if average is a dash -->
            <?php if ($fixture_details['average'] === '-') { 
                // Do not show any arrow if average is '-'
                echo ''; 
            } else {
                // Proceed to check the conditions for showing arrows
                if (intval($fixture_details['game_details']['goals_home']) + intval($fixture_details['game_details']['goals_away']) >= 3 && $fixture_details['average'] >= 2.5) { ?>
                    <i class="bi bi-arrow-up"></i>
                <?php } elseif (intval($fixture_details['game_details']['goals_home']) + intval($fixture_details['game_details']['goals_away']) < 3 && $fixture_details['average'] < 2.5) { ?>
                    <i class="bi bi-arrow-down"></i>
                <?php }
            } ?>
        </div>
        <?php
        // Desktop view
        if ($deviceType === "desktop") { 
        ?>
            <div class="responsive-cell hide-on-mobile" title="Prediction">
                <br />
                <?php

                // Handle prediction logic
                if (($fixture_details['home_odd'] === "-" || empty($fixture_details['home_odd'])) &&
                    ($fixture_details['draw_odd'] === "-" || empty($fixture_details['draw_odd'])) &&
                    ($fixture_details['away_odd'] === "-" || empty($fixture_details['away_odd']))) {
                    echo "-";
                } elseif($routerPath === "" || strpos($routerPath, "tips") !== false) {
                    if ($fixture_details['average'] < 1.5 || $fixture_details['average'] > 6.0) {
                        echo $under_over_pred_value;
                    } elseif (
                        ($fixture_details['winning_team'] === "1" && $fixture_details['home_odd'] < "50") ||
                        ($fixture_details['winning_team'] === "X" && $fixture_details['draw_odd'] < "50") ||
                        ($fixture_details['winning_team'] === "2" && $fixture_details['away_odd'] < "50")
                    ) {
                        echo $dc_winning_pred_value;
                    } else {
                        echo $fixture_details["probability_results"];
                    }
                } else {
                    echo $fixture_details["probability_results"];
                }
                ?>
            </div>
        <?php
        // Mobile view
        } else {
        ?>
            <div class="responsive-cell team-link-standings" title="Prediction" style="font-weight: bold; text-align: center;">
                <br />
                <?php
                // Check prediction for mobile
                if (($fixture_details['home_odd'] === "-" || empty($fixture_details['home_odd'])) &&
                    ($fixture_details['draw_odd'] === "-" || empty($fixture_details['draw_odd'])) &&
                    ($fixture_details['away_odd'] === "-" || empty($fixture_details['away_odd']))) {
                    echo "-";
                } elseif($routerPath === "" || strpos($routerPath, "tips") !== false) {
                    if ($fixture_details['average'] < 1.5 || $fixture_details['average'] > 6.0) {
                        echo $under_over_pred_value;
                    } elseif (
                        ($fixture_details['winning_team'] === "1" && $fixture_details['home_odd'] < "50") ||
                        ($fixture_details['winning_team'] === "X" && $fixture_details['draw_odd'] < "50") ||
                        ($fixture_details['winning_team'] === "2" && $fixture_details['away_odd'] < "50")
                    ) {
                        echo $dc_winning_pred_value;
                    } else {
                        echo $fixture_details["probability_results"];
                    }
                } else {
                    echo $fixture_details["probability_results"];
                }
                ?>
                <br /><br />
                <span style="font-weight: bold;">
                    <?php
                    // Calculate and display winning probability %
                    if (($fixture_details['home_odd'] === "-" || empty($fixture_details['home_odd'])) &&
                        ($fixture_details['draw_odd'] === "-" || empty($fixture_details['draw_odd'])) &&
                        ($fixture_details['away_odd'] === "-" || empty($fixture_details['away_odd']))) {
                        echo "-";
                    } else {
                        if (strpos($routerPath, "double-chance-predictions") !== false) {
                            // Double chance predictions
                            if ($dc_winning_pred_value === "1X") {
                                echo (intval($fixture_details['home_odd']) + intval($fixture_details['draw_odd'])) . "%";
                            } elseif ($dc_winning_pred_value === "X2") {
                                echo (intval($fixture_details['draw_odd']) + intval($fixture_details['away_odd'])) . "%";
                            } else {
                                echo (intval($fixture_details['home_odd']) + intval($fixture_details['away_odd'])) . "%";
                            }
                        } elseif (strpos($routerPath, "predictions-under-over") !== false) {
                            // Over/Under 2.5 Predictions
                            echo $fixture_details['average'] != "-" ? $over_under_prob_percentage[1] . "%" : "-";
                        } elseif (strpos($routerPath, "predictions-both-to-score") !== false) {
                            // Predictions for both teams to score
                            if (!empty($fixture_details['game_details']['both_team_to_score'])) {
                                echo (max(intval($fixture_details['home_odd']), intval($fixture_details['draw_odd']), intval($fixture_details['away_odd'])) +
                                    min(intval($fixture_details['home_odd']), intval($fixture_details['draw_odd']), intval($fixture_details['away_odd']))) . "%";
                            }
                        } elseif ($routerPath === "") {
                            if ($fixture_details['average'] < 1.5 || $fixture_details['average'] > 6.0) {
                                echo $fixture_details['average'] != "-" ? $over_under_prob_percentage[1] . "%" : "-";
                            } elseif (
                                ($fixture_details['winning_team'] === "1" && $fixture_details['home_odd'] < "50") ||
                                ($fixture_details['winning_team'] === "X" && $fixture_details['draw_odd'] < "50") ||
                                ($fixture_details['winning_team'] === "2" && $fixture_details['away_odd'] < "50")
                            ) {
                                if ($dc_pred_value2 === "1X") {
                                    echo (intval($fixture_details['home_odd']) + intval($fixture_details['draw_odd'])) . "%";
                                } elseif ($dc_pred_value2 === "X2") {
                                    echo (intval($fixture_details['draw_odd']) + intval($fixture_details['away_odd'])) . "%";
                                } else {
                                    echo (intval($fixture_details['home_odd']) + intval($fixture_details['away_odd'])) . "%";
                                }
                            } else {
                                echo $fixture_details['winning_team'] === '1' ? $fixture_details['home_odd'] . "%" : 
                                    ($fixture_details['winning_team'] === 'X' ? $fixture_details['draw_odd'] . "%" : 
                                    $fixture_details['away_odd'] . "%");
                            }
                        } else {
                            echo $fixture_details['winning_team'] === '1' ? $fixture_details['home_odd'] . "%" : 
                                ($fixture_details['winning_team'] === 'X' ? $fixture_details['draw_odd'] . "%" : 
                                $fixture_details['away_odd'] . "%");
                        }
                    }
                    ?>
                </span>
            </div>
        <?php
        }?>
        <div class="responsive-cell hide-on-mobile" title="Winning Probability" style="font-weight:bold;"> 
            <!-- Winning Probability % -->
            <span class="<?php 
                // Check if any odds are not set or equal to "-"
                echo ($fixture_details['home_odd'] == "-" || is_null($fixture_details['home_odd']) || $fixture_details['home_odd'] == "") && 
                    ($fixture_details['draw_odd'] == "-" || is_null($fixture_details['draw_odd']) || $fixture_details['draw_odd'] == "") && 
                    ($fixture_details['away_odd'] == "-" || is_null($fixture_details['away_odd']) || $fixture_details['away_odd'] == "") 
                    ? "" : "predictionHoverEffect"; 
            ?>">
                <?php 
                // Determine the winning probability based on conditions
                if (($fixture_details['home_odd'] == "-" || is_null($fixture_details['home_odd']) || $fixture_details['home_odd'] == "") && 
                    ($fixture_details['draw_odd'] == "-" || is_null($fixture_details['draw_odd']) || $fixture_details['draw_odd'] == "") && 
                    ($fixture_details['away_odd'] == "-" || is_null($fixture_details['away_odd']) || $fixture_details['away_odd'] == "")) {
                    echo "-";
                } elseif (strpos($_SERVER['REQUEST_URI'], "double-chance-predictions") !== false) { // Double chance Predictions
                    if ($dc_winning_pred_value === "1X") {
                        echo (intval($fixture_details['home_odd']) + intval($fixture_details['draw_odd'])) . "%";
                    } elseif ($dc_winning_pred_value === "X2") {
                        echo (intval($fixture_details['draw_odd']) + intval($fixture_details['away_odd'])) . "%";
                    } else {
                        echo (intval($fixture_details['home_odd']) + intval($fixture_details['away_odd'])) . "%";
                    }
                } elseif (strpos($_SERVER['REQUEST_URI'], "predictions-under-over") !== false) { // Over/Under 2.5 Predictions
                    echo ($fixture_details['average'] != "-" ? $over_under_prob_percentage[1] . "%" : "-");
                } elseif (strpos($_SERVER['REQUEST_URI'], "predictions-both-to-score") !== false) { // Predictions-both-to-score
                    if (!is_null($fixture_details['game_details']['both_team_to_score'])) {
                        echo max(intval($fixture_details['home_odd']), intval($fixture_details['draw_odd']), intval($fixture_details['away_odd'])) + 
                            min(intval($fixture_details['home_odd']), intval($fixture_details['draw_odd']), intval($fixture_details['away_odd'])) . "%";
                    } else {
                        echo "-";
                    }
                } elseif ($routerPath == "") { // Prediction 1x2, except for landing page
                    if (($fixture_details['average'] < 1.5 || $fixture_details['average'] > 6.0) && $fixture_details['average'] != "-") {
                        echo ($fixture_details['average'] != "-" ? $over_under_prob_percentage[1] . "%" : "-");
                    }elseif (($fixture_details['winning_team'] === "1" && intval($fixture_details['home_odd']) < 40) || 
                        ($fixture_details['winning_team'] === "X" && intval($fixture_details['draw_odd']) < 40) || 
                        ($fixture_details['winning_team'] === "2" && intval($fixture_details['away_odd']) < 40)) {
                        
                        if ($dc_pred_value2 === "1X") {
                            echo (intval($fixture_details['home_odd']) + intval($fixture_details['draw_odd'])) . "%";
                        } elseif ($dc_pred_value2 === "X2") {
                            echo (intval($fixture_details['draw_odd']) + intval($fixture_details['away_odd'])) . "%";
                        } else {
                            echo (intval($fixture_details['home_odd']) + intval($fixture_details['away_odd'])) . "%";
                        }
                    } else {
                        echo $fixture_details['winning_team'] === '1' ? $fixture_details['home_odd'] . "%" : 
                        ($fixture_details['winning_team'] === 'X' ? $fixture_details['draw_odd'] . "%" : 
                        $fixture_details['away_odd'] . "%");
                    }
                } else {
                    echo $fixture_details['winning_team'] === '1' ? $fixture_details['home_odd'] . "%" : 
                    ($fixture_details['winning_team'] === 'X' ? $fixture_details['draw_odd'] . "%" : 
                    $fixture_details['away_odd'] . "%");
                }
                ?>
            </span>
        </div>

        <?php
        // Conditional rendering for status
        if ($deviceType === "desktop") { // Desktop version
            ?>
            <div class="responsive-cell team-link-standings hide-on-mobile" style="color: red; white-space: pre-wrap;" title="Status">
                <span style="white-space: pre-wrap;"><?php echo $fixture_details['livestatus']; ?></span>
            </div>
            <?php
        } else { // Mobile version
            ?>
            <div class="responsive-cell team-link-l" style="color: red; white-space: nowrap;" title="Status">
                <br/><span style="white-space: nowrap;"><?php echo $fixture_details['livestatus']; ?></span>
            </div>
            <?php
        }
        ?>
        <div class="responsive-cell team-link-scores" style="color: red;" title="Scores">
            <?php 
            // Add a line break if the device is desktop
            echo '<br />';

            // Display extra time data if available
            if (!empty($fixture_details['extratime_data'])) {
                echo '<span style="color: black;">' . $fixture_details['extratime_data'] . '</span><br />';
            } 

            // Display live scores and half-time data
            echo $fixture_details['livescores'] . '<br />';
            ?>
            
            <span class="halfTimeDataDisplay" style="color: black;">
                <?php echo $fixture_details['halftime_data']; ?>
            </span>
        </div>
    </div>
    <?php

    return ob_get_clean();
}
