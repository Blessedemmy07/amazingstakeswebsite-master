<?php
function ProbabilityResults($game_details, $winning_team) {
    $probability_results = "";

    // Determine if prediction was right or wrong
    if (in_array($game_details['status_short'], ["NS", "HT", "2H", "1H", "INT", "ET", "TBD", "LIVE", "BT", "ABD"])) {
        $probability_results = '<span class="number-circle rounded-square" style="background-color:#ffb400;">' . $winning_team . '</span>';
    } elseif ($game_details['status_short'] === "CANC" || $game_details['status_short'] === "PST") {
        $probability_results = '<span class="number-circle rounded-square" style="background-color:#ffb400;color:white;font-weight:bold;text-transform:lowercase;">' . $winning_team . '</span>';
    } elseif (in_array($game_details['status_short'], ["FT", "AWD", "PEN", "AET"])) {
        if ($winning_team == 1 && $game_details['goals_home'] > $game_details['goals_away']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team == 2 && $game_details['goals_away'] > $game_details['goals_home']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team == "Under2.5" && (intval($game_details['goals_home']) + intval($game_details['goals_away'])) <= 3) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team == "Over2.5" && (intval($game_details['goals_home']) + intval($game_details['goals_away'])) >= 3) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team == 1 && $game_details['goals_home'] < $game_details['goals_away']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team == 1 && $game_details['goals_home'] == $game_details['goals_away']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team == 2 && $game_details['goals_away'] < $game_details['goals_home']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team == 2 && $game_details['goals_away'] == $game_details['goals_home']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team == 'X' && $game_details['goals_away'] == $game_details['goals_home']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team == 'X' && $game_details['goals_away'] != $game_details['goals_home']) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team == "Under2.5" && (intval($game_details['goals_home']) + intval($game_details['goals_away'])) >= 3) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team == "Over2.5" && (intval($game_details['goals_home']) + intval($game_details['goals_away'])) < 3) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team === '1X' && ($game_details['goals_home'] > $game_details['goals_away'] || $game_details['goals_home'] === $game_details['goals_away'])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team === '12' && ($game_details['goals_home'] > $game_details['goals_away'] || $game_details['goals_away'] > $game_details['goals_home'])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team === 'X2' && ($game_details['goals_home'] === $game_details['goals_away'] || $game_details['goals_home'] > $game_details['goals_away'])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:green;">' . $winning_team . '</span>';
        } elseif ($winning_team === '1X' && !($game_details['goals_home'] > $game_details['goals_away'] || $game_details['goals_home'] === $game_details['goals_away'])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team === '12' && !($game_details['goals_home'] > $game_details['goals_away'] || $game_details['goals_away'] > $game_details['goals_home'])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        } elseif ($winning_team === 'X2' && !($game_details['goals_home'] === $game_details['goals_away'] || $game_details['goals_home'] > $game_details['goals_away'])) {
            $probability_results = '<span class="number-circle rounded-square" style="background-color:white;border:1px solid red;color:red;">' . $winning_team . '</span>';
        }
    }

    return $probability_results;
}
