<?php
function DoubleChanceProbabilityResults($game_details, $winning_team, $url) {
    $probability_results = "";

    // Determine if prediction was right or wrong
    if (in_array($game_details['status_short'], ['NS', 'HT', '2H', '1H', 'INT', 'TBD', 'LIVE', 'BT', 'ABD'])) {
        $probability_results = '<span class="number-circle rounded-square" style="background-color: #ffb400;">' . $winning_team . '</span>';
    } elseif (in_array($game_details['status_short'], ['CANC', 'PST'])) {
        $probability_results = '<span class="number-circle rounded-square" style="background-color: #ffb400; color: black; font-weight: bold; font-size: 12px; text-transform: lowercase;">' 
            . $game_details['status_short'] . '</span>';
    } elseif (in_array($game_details['status_short'], ['FT', 'AWD', 'PEN', 'AET'])) {
        if (is_numeric($game_details['goals_home']) && is_numeric($game_details['goals_away'])) {
            if (
                ($winning_team === "1X" && ($game_details['goals_home'] >= $game_details['goals_away'])) ||
                ($winning_team === "X2" && ($game_details['goals_away'] >= $game_details['goals_home'])) ||
                ($winning_team === "12" && $game_details['goals_home'] !== $game_details['goals_away'])
            ) {
                $probability_results = '<span class="number-circle rounded-square" style="background-color: green;">' . $winning_team . '</span>';
            } else {
                $border_color = strpos($url, "jackpots") !== false ? "black" : "red";
                $text_color = strpos($url, "jackpots") !== false ? "black" : "red";
                
                $probability_results = '<span class="number-circle rounded-square" style="background-color: white; border: 2px solid ' . $border_color . '; color: ' . $text_color . ';">' 
                    . $winning_team . '</span>';
            }
        } else {
            $probability_results = '<span class="number-circle rounded-square" style="background-color: #ffb400;">' . $winning_team . '</span>';
        }
    }

    return $probability_results;
}
