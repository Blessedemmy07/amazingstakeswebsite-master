<?php
function computeFixtureAverage($goals_for_home, $goals_against_home, $goals_for_away, $goals_against_away, $total_games_played_by_home, $total_games_played_by_away) {
    // Check if any of the goal values or total games played is not null
    if (($goals_for_home || $goals_for_away) && ($total_games_played_by_home || $total_games_played_by_away) !== null) {
        // Calculate total average goals
        $total_average_goals = (int)$goals_for_home + (int)$goals_against_home + (int)$goals_for_away + (int)$goals_against_away;
        $total_played = (int)$total_games_played_by_home + (int)$total_games_played_by_away;
    
        // Calculate average goals
        $average_goals = $total_played > 0 ? $total_average_goals / $total_played : 0;

        // Return formatted average goals or "-"
        return $average_goals > 0 ? number_format($average_goals, 2) : "-";
    } else {
        return "-";
    }
}