<?php
function WinningTeamAndOdd($hometeamodd, $drawodd, $awayteamodd, $game_details) {
    // Check if game_details is valid and contains the necessary data
    if (!is_array($game_details) || !isset($game_details['bets_home'], $game_details['bets_draw'], $game_details['bets_away'])) {
        return ['X', 0]; // Return default prediction if data is invalid
    }

    $winning_team = "";
    $winning_odd = 0;

    $winning_odd_home = $game_details['bets_home'];
    $winning_odd_draw = $game_details['bets_draw'];
    $winning_odd_away = $game_details['bets_away'];

    // Check if odds are valid (not null or empty)
    if (empty($hometeamodd) || empty($drawodd) || empty($awayteamodd)) {
        return ['X', 0]; // Default if odds are invalid or empty
    }

    // Determine prediction based on odds comparison
    if ($hometeamodd > $drawodd && $hometeamodd > $awayteamodd) {
        $winning_team = "1";
        $winning_odd = $winning_odd_home;
    } elseif ($drawodd > $hometeamodd && $drawodd > $awayteamodd) {
        $winning_team = "X";
        $winning_odd = $winning_odd_draw;
    } elseif ($awayteamodd > $drawodd && $awayteamodd > $hometeamodd) {
        $winning_team = "2";
        $winning_odd = $winning_odd_away;
    } elseif ($drawodd == $hometeamodd && $awayteamodd < $hometeamodd) {
        $winning_team = "1";
        $winning_odd = $winning_odd_home;
    } elseif ($drawodd == $hometeamodd && $awayteamodd > $drawodd) {
        $winning_team = "2";
        $winning_odd = $winning_odd_away;
    } elseif ($drawodd == $awayteamodd && $hometeamodd < $awayteamodd) {
        $winning_team = "X";
        $winning_odd = $winning_odd_draw;
    } elseif ($hometeamodd == $awayteamodd && $hometeamodd > $drawodd) {
        $winning_team = "1";
        $winning_odd = $winning_odd_home;
    } elseif ($hometeamodd == $drawodd && $drawodd == $awayteamodd) {
        $winning_team = "X";
        $winning_odd = $winning_odd_draw;
    }

    // Return the winning team and odd in an array
    return [$winning_team, $winning_odd];
}
