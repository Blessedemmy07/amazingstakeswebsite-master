<?php
function getColorAndBorder($status) {
    return in_array($status, ["FT", "AWD", "AET", "PEN", "WO", "ABD"]) ? "black" : "#B11111";
}

function determineLiveScores($game_details, $device) {
    $live_scores_data_array = [];
    $myNewTimeZoneDate = date('H:i', strtotime($game_details['date'])); // Convert the date to desired timezone format
    $livestatus = "";
    $livescores = "";

    $borderColor = getColorAndBorder($game_details['status_short']);

    // Determine live scores based on game status
    if (in_array($game_details['status_short'], ["NS", "CANC", "TBD"])) {
        if ($game_details['status_short'] === "NS") {
            $livestatus = "<span style='color: black;'>$myNewTimeZoneDate</span>";
            $livescores = "<span style='color: black;'>-</span>";
        } else {
            $livestatus = "<span style='color: black;'>" . ($device== 'mobile'  ? $game_details['status_short'] : $game_details['status_long']) . "</span>";
            $livescores = "<span style='color: black;'>-</span>";
        }
    } elseif (in_array($game_details['status_short'], ["FT", "AWD", "AET", "PEN", "WO", "ABD"])) {
        if (in_array($game_details['status_short'], ["FT", "ABD"])) {
            $livestatus = "<span style='color: black; border: All;'>" . ($device== 'mobile'  ? $game_details['status_short'] : $game_details['status_long']) . "</span>";
        } else {
            $livestatus = "<span style='white-space: pre-wrap;'>";
            $livestatus .= "<span style='color: black; border: All; text-transform: capitalize;'>" . ($device== 'mobile'  ? $game_details['status_short'] : 
                ($game_details['status_short'] === "PEN" ? "After Penalties" : 
                ($game_details['status_short'] === "AET" ? "After Extra Time" : 
                ($game_details['status_short'] === "WO" ? "Walk Over" : 
                ($game_details['status_short'] === "ABD" ? "Match Abandoned" : $game_details['status_long']))))) . 
                "</span><br /></span>";
        }

        $livescores = "<span class='scores-card' id='fulltimeGoals' style='color: " . $borderColor . "; border-color: " . $borderColor . ";'>";
        $livescores .= isset($game_details['goals_home']) ? $game_details['goals_home'] . " - " . $game_details['goals_away'] : "";
        $livescores .= "</span>";
    } elseif (in_array($game_details['status_short'], ["2H", "1H", "INT", "HT", "LIVE"])) {
        $livestatus = "<span style='color: #B11111; font-weight: bold; border: none;'>";
        $livestatus .= (in_array($game_details['status_short'], ["HT"]) || !isset($game_details['status_elapased']) || $game_details['status_elapased'] === "")
            ? ($device== 'mobile'  ? $game_details['status_short'] : $game_details['status_long'])
            : $game_details['status_elapased'];
        $livestatus .= (in_array($game_details['status_short'], ["HT"]) || !isset($game_details['status_elapased']) || $game_details['status_elapased'] === "")
            ? ""
            : "<span class='blink_text' style='color: #B11111;'>'</span>";
        $livestatus .= "</span>";

        $livescores = "<span class='scores-card' id='fulltimeGoals' style='font-weight: bold; border: 1px solid; color: #B11111;'>";
        $livescores .= isset($game_details['goals_home']) ? $game_details['goals_home'] . " - " . $game_details['goals_away'] : "";
        $livescores .= "</span>";
    } elseif (in_array($game_details['status_short'], ["ET", "PE", "BT", "P"])) {
        $livestatus = "<span style='color: #B11111; font-weight: bold; border: none; margin-bottom: 10px;'><br />";
        $livestatus .= ($device== 'mobile' 
            ? (isset($game_details['status_elapased']) && $game_details['status_elapased'] !== "" ? 
                $game_details['status_short'] . "" . $game_details['status_elapased'] . "<span class='blink_text' style='color: #B11111;'>'</span>" 
                : $game_details['status_short'])
            : (isset($game_details['status_elapased']) && $game_details['status_elapased'] !== "" ? 
                $game_details['status_long'] . "" . $game_details['status_elapased'] . "<span class='blink_text' style='color: #B11111;'>'</span>" 
                : $game_details['status_long'])
        ) . "</span>";

        $livescores = "<span class='scores-card' id='fulltimeGoals' style='font-weight: bold; border: 1px solid; color: " . $borderColor . ";'>";
        $livescores .= isset($game_details['goals_home']) ? $game_details['goals_home'] . " - " . $game_details['goals_away'] : "";
        $livescores .= "</span>";
    }

    // Add the live status and scores to the array
    $live_scores_data_array[] = $livestatus;
    $live_scores_data_array[] = $livescores;

    return $live_scores_data_array;
}
