<?php
function BothTeamsToScore($game_details) {
    $probability_results = "";

    if ($game_details['both_team_to_score'] !== null) {
        // Determine if prediction was right or wrong
        if (in_array($game_details['status_short'], ["NS", "HT", "2H", "1H", "INT", "TBD", "LIVE", "BT", "ABD"])) {
            // Yellow for in-progress matches
            $probability_results = "<span class='number-circle rounded-square' style='background-color: #ffb400; border: 2px solid; border-color: #ffb400; color: white;'>"
                . capitalizeFirstLetter($game_details['both_team_to_score']) . "</span>";
        } elseif (in_array($game_details['status_short'], ["CANC", "PST"])) {
            // Yellow with lowercase text for canceled or postponed matches
            $probability_results = "<span class='number-circle rounded-square' style='background-color: #ffb400; color: black; font-weight: bold; font-size: 12px; text-transform: lowercase;'>"
                . capitalizeFirstLetter($game_details['both_team_to_score']) . "</span>";
        } elseif (in_array($game_details['status_short'], ["FT", "AWD", "PEN", "AET"])) {
            // Check if goals_home and goals_away are not null
            if ($game_details['goals_home'] !== null && $game_details['goals_away'] !== null) {
                if ($game_details['both_team_to_score'] === "Yes") {
                    if ($game_details['goals_home'] !== "0" && $game_details['goals_away'] !== "0") {
                        // Green for correct "yes" prediction
                        $probability_results = "<span class='number-circle rounded-square' style='background-color: green; border: 2px solid; border-color: green; color: white;'>"
                            . capitalizeFirstLetter($game_details['both_team_to_score']) . "</span>";
                    } else {
                        // Red for incorrect "yes" prediction
                        $probability_results = "<span class='number-circle rounded-square' style='background-color: red; border: 2px solid; border-color: red; color: white;'>"
                            . capitalizeFirstLetter($game_details['both_team_to_score']) . "</span>";
                    }
                } elseif ($game_details['both_team_to_score'] === "No") {
                    if ($game_details['goals_home'] === "0" || $game_details['goals_away'] === "0") {
                        // Green for correct "no" prediction
                        $probability_results = "<span class='number-circle rounded-square' style='background-color: green; border: 2px solid; border-color: green; color: white;'>"
                            . capitalizeFirstLetter($game_details['both_team_to_score']) . "</span>";
                    } else {
                        // Red for incorrect "no" prediction
                        $probability_results = "<span class='number-circle rounded-square' style='background-color: red; border: 2px solid; border-color: red; color: white;'>"
                            . capitalizeFirstLetter($game_details['both_team_to_score']) . "</span>";
                    }
                }
            } else {
                // Yellow for unknown match status or missing data
                $probability_results = "<span class='number-circle rounded-square' style='background-color: #ffb400; border: 2px solid; border-color: #ffb400; color: white;'>"
                    . capitalizeFirstLetter($game_details['both_team_to_score']) . "</span>";
            }
        }
    } else {
        // Display "-" if there is no prediction available
        $probability_results = "-";
    }

    return $probability_results;
}

function capitalizeFirstLetter($str) {
    return ($str === "yes" || $str === "no") ? ucfirst(strtolower($str)) : $str;
}
?>
