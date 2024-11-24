<?php

function ComputedWinDrawings($teamId, $homeTeamId, $awayTeamId, $home, $away) {
    $result = '';

    if ($teamId === $homeTeamId) {
        if ($home > $away) {
            $result = '<span class="number-circle rounded-square fixturesTextSize" style="background-color:green;">W</span>';
        } elseif ($home === $away) {
            $result = '<span class="number-circle rounded-square fixturesTextSize" style="background-color:#ffb400;">D</span>';
        } else {
            $result = '<span class="number-circle rounded-square fixturesTextSize" style="background-color:red;">L</span>';
        }
    } elseif ($teamId === $awayTeamId) {
        if ($away > $home) {
            $result = '<span class="number-circle rounded-square fixturesTextSize" style="background-color:green;">W</span>';
        } elseif ($away === $home) {
            $result = '<span class="number-circle rounded-square fixturesTextSize" style="background-color:#ffb400;">D</span>';
        } else {
            $result = '<span class="number-circle rounded-square fixturesTextSize" style="background-color:red;">L</span>';
        }
    }

    return $result;
}