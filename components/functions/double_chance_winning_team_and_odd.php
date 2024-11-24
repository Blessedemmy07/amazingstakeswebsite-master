<?php
function DoubleChanceWinningTeamAndOdd($hometeamodd, $drawodd, $awayteamodd, $game_details, $url) {
    $winning_team = "";
    $winning_odd = 0;

    $winning_preds_array = [];

    $winning_odd_home = "";
    $winning_odd_draw = "";
    $winning_odd_away = "";

    // Ensure 'double_chance_goals' exists and is a valid string
    if (!empty($game_details['double_chance_goals']) && is_string($game_details['double_chance_goals'])) {
        // Decode the double chance odds from the game details
        $double_chance_odds = json_decode($game_details['double_chance_goals'], true);
    } else {
        $double_chance_odds = null;
    }

    if ($double_chance_odds != null) {
        if (count($double_chance_odds) >= 3) {
            $winning_odd_home = isset($double_chance_odds[0]['odd']) ? $double_chance_odds[0]['odd'] : "-";
            $winning_odd_draw = isset($double_chance_odds[1]['odd']) ? $double_chance_odds[1]['odd'] : "-";
            $winning_odd_away = isset($double_chance_odds[2]['odd']) ? $double_chance_odds[2]['odd'] : "-";
        }
    }

    // Determine the prediction
    if (($hometeamodd > $drawodd && $hometeamodd > $awayteamodd) && $drawodd > $awayteamodd) {
        $winning_team = "1X";
        $winning_odd = $winning_odd_home;

    } elseif (($hometeamodd > $drawodd && $hometeamodd > $awayteamodd) && $drawodd === $awayteamodd) {
        $winning_team = "1X";
        $winning_odd = $winning_odd_home;

    } elseif (($awayteamodd > $drawodd && $awayteamodd > $hometeamodd) && $drawodd === $hometeamodd) {
        $winning_team = "X2";
        $winning_odd = $winning_odd_away;

    } elseif (($drawodd > $hometeamodd && $drawodd > $awayteamodd) && $awayteamodd > $hometeamodd) {
        $winning_team = "X2";
        $winning_odd = $winning_odd_away;

    } elseif (($drawodd > $hometeamodd && $drawodd > $awayteamodd) && $hometeamodd > $awayteamodd) {
        $winning_team = "1X";
        $winning_odd = $winning_odd_away;

    } elseif (($awayteamodd > $hometeamodd && $awayteamodd > $drawodd) && $hometeamodd > $drawodd) {
        $winning_team = "12";
        $winning_odd = $winning_odd_away;

    } elseif (($awayteamodd > $hometeamodd && $awayteamodd > $drawodd) && $drawodd > $hometeamodd) {
        $winning_team = "X2";
        $winning_odd = $winning_odd_away;

    } elseif (($hometeamodd > $drawodd && $hometeamodd > $awayteamodd) && $awayteamodd > $drawodd) {
        $winning_team = "12";
        $winning_odd = $winning_odd_draw;

    } elseif ($hometeamodd == $drawodd && $drawodd == $awayteamodd) {
        $winning_team = "1X";
        $winning_odd = $winning_odd_home;

    } elseif ($hometeamodd == $drawodd && $hometeamodd > $awayteamodd) {
        $winning_team = "1X";
        $winning_odd = $winning_odd_home;

    } elseif ($hometeamodd == $awayteamodd && $hometeamodd > $drawodd) {
        $winning_team = "12";
        $winning_odd = $winning_odd_home;

    } elseif ($awayteamodd == $drawodd && $awayteamodd > $hometeamodd) {
        $winning_team = "X2";
        $winning_odd = $winning_odd_away;

    } elseif ($hometeamodd == $awayteamodd && $drawodd > $hometeamodd) {
        $winning_team = "X2";
        $winning_odd = $winning_odd_home;

    } elseif ($hometeamodd == $awayteamodd && $drawodd > $awayteamodd) {
        $winning_team = "1X";
        $winning_odd = $winning_odd_home;
    }

    $winning_preds_array[] = $winning_team;
    $winning_preds_array[] = $winning_odd;

    return $winning_preds_array;
}
