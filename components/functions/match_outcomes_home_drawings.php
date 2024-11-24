<?php
function MatchOutcomesHome($game_details, $home_team_id) {
    $home_team_matches = $game_details;
    $computedWins = [];

    $home_team_name = $home_team_matches['home_team_name'];
    $away_team_name = $home_team_matches['away_team_name'];
    $goals_home = $home_team_matches['goals_home'];
    $goals_away = $home_team_matches['goals_away'];
    $date = $home_team_matches['date'];
    $fixture_id = $home_team_matches['fixture_id'];

    $tooltipTitle = $home_team_name . ' (' . $goals_home . '-' . $goals_away . ') ' . $away_team_name . "\n" . $date;

    $url_name = urlencode(strtolower(str_replace(' ', '-', $home_team_name) . '-vs-' . str_replace(' ', '-', $away_team_name) . '-' . $fixture_id));

    $match_result = '';

    if ($home_team_id == $home_team_matches['home_team_id']) {
        if ($goals_home > $goals_away) {
            // Win
            $match_result = "<span class='number-circle rounded-square' style='background-color: green; margin: 0.5px; cursor: pointer;' title='$tooltipTitle'>W</span>";
        } elseif ($goals_home == $goals_away) {
            // Draw
            $match_result = "<span class='number-circle rounded-square' style='background-color: #ffb400; margin: 0.5px; cursor: pointer;' title='$tooltipTitle'>D</span>";
        } else {
            // Loss
            $match_result = "<span class='number-circle rounded-square' style='background-color: red; margin: 0.5px; cursor: pointer;' title='$tooltipTitle'>L</span>";
        }
    } elseif ($home_team_id == $home_team_matches['away_team_id']) {
        if ($goals_away > $goals_home) {
            // Win
            $match_result = "<span class='number-circle rounded-square' style='background-color: green; margin: 0.5px; cursor: pointer;' title='$tooltipTitle'>W</span>";
        } elseif ($goals_away == $goals_home) {
            // Draw
            $match_result = "<span class='number-circle rounded-square' style='background-color: #ffb400; margin: 0.5px; cursor: pointer;' title='$tooltipTitle'>D</span>";
        } else {
            // Loss
            $match_result = "<span class='number-circle rounded-square' style='background-color: red; margin: 0.5px; cursor: pointer;' title='$tooltipTitle'>L</span>";
        }
    }

    if ($match_result) {
        $computedWins[] = "<a href='/match/football-predictions-" . $url_name . "/matches' title='Click to View Match details'>" . $match_result . "</a>";
    }

    return implode("\n", $computedWins);
}
?>
