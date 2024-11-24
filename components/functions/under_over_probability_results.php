<?php
function UnderOverProbabilityResults($game_details, $winning_team) {
    $probability_results = "";

    if ($winning_team == "-") {
        $probability_results = "-";
    } else {
        // Determine if the prediction was right or wrong
        if (in_array($game_details['status_short'], ["NS", "HT", "2H", "1H", "INT", "TBD", "LIVE", "BT", "ABD"])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:#ffb400;border:2px solid;border-color:#ffb400;color:white;">' . $winning_team . '</span>';
        } elseif (in_array($game_details['status_short'], ["CANC", "PST"])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:#ffb400;color:black;font-weight:bold;font-size:12px;text-transform:lowercase;">' . $game_details['status_short'] . '</span>';
        } elseif (in_array($game_details['status_short'], ["FT", "AWD", "PEN", "AET"])) {
            // Greens (correct predictions) start here
            if (!is_null($game_details['goals_home']) && !is_null($game_details['goals_away'])) {
                $total_goals = intval($game_details['goals_home']) + intval($game_details['goals_away']);

                if (($winning_team == "Under" || $winning_team == "OU") && $total_goals < 3) {
                    $probability_results = '<span class="number-circle rounded-square" style="background-color:green;border:2px solid;border-color:green;color:white;">' . $winning_team . '</span>';
                } elseif (($winning_team == "Over" || $winning_team == "OV") && $total_goals >= 3) {
                    $probability_results = '<span class="number-circle rounded-square" style="background-color:green;border:2px solid;border-color:green;color:white;">' . $winning_team . '</span>';
                } elseif (($winning_team == "Under" || $winning_team == "OU") && $total_goals >= 3) {
                    $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:2px solid;border-color:red;color:red;">' . $winning_team . '</span>';
                } elseif (($winning_team == "Over" || $winning_team == "OV") && $total_goals < 3) {
                    $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:2px solid;border-color:red;color:red;">' . $winning_team . '</span>';
                }
            } else {
                $probability_results = '<span class="number-circle rounded-square" style="background-color:#ffb400;border:2px solid;border-color:#ffb400;color:white;">' . $winning_team . '</span>';
            }
        }
    }

    return $probability_results;
}
