<?php
function OverUnderProbabilitiesScale($avgGoals) {
    $over_under_prob_prediction = array();

    // Check if avgGoals is "-" and return "-"
    if ($avgGoals === '-') {
        return '-';
    }

    // Ensure avgGoals is a numeric value before calculating
    if (!is_numeric($avgGoals)) {
        return '-'; // Or handle the error in another way
    }

    $probability = 90;
    $division_factor = 0;

    if ($avgGoals > 10) {
        $division_factor = 11.0;
    } elseif ($avgGoals > 5.0) {
        $division_factor = 8.0;
    } else {
        $division_factor = 5.0;
    }

    $probability_1 = intval($probability / ($division_factor / $avgGoals)) + 5;
    $probability_2 = 100 - $probability_1;

    // Push values to array
    array_push($over_under_prob_prediction, $probability_1, $probability_2);

    return $over_under_prob_prediction;
}