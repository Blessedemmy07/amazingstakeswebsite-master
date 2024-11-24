<?php
function UnderOverWinningTeamAndOdd($averageGoals, $isMobile) {
    $winning_team = "";
    $winning_odd = "";

    $winning_preds_array = [];

    if ($averageGoals === "-") {
        $winning_team = "-";
    } else {
        // Determine prediction
        if ($averageGoals < 2.5) {
            if ($isMobile === true) {
                $winning_team = "UN";
            } else {
                $winning_team = "Under";
            }
        } elseif ($averageGoals >= 2.5) {
            if ($isMobile === true) {
                $winning_team = "OV";
            } else {
                $winning_team = "Over";
            }
        }
    }

    // Push results into the array
    array_push($winning_preds_array, $winning_team, $winning_odd);

    return $winning_preds_array;
}
